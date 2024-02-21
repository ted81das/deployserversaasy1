<?php

namespace App\Services;

use App\Constants\OrderStatus;
use App\Dto\CartDto;
use App\Dto\TotalsDto;
use App\Events\Order\Ordered;
use App\Models\OneTimeProduct;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderManager
{
    public function __construct(
        private CalculationManager $calculationManager,
    ) {}

    public function create(User $user): Order
    {
        return Order::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $user->id,
            'status' => OrderStatus::NEW,
            'total_amount' => 0,
        ]);
    }

    public function findByUuidOrFail(string $uuid): Order
    {
        return Order::where('uuid', $uuid)->firstOrFail();
    }

    public function updateOrder(
        Order $order,
        array $data
    ): Order {
        $oldStatus = $order->status;
        $newStatus = $data['status'] ?? $oldStatus;
        $order->update($data);

        $this->handleDispatchingEvents(
            $oldStatus,
            $newStatus,
            $order
        );

        return $order;
    }

    private function handleDispatchingEvents(
        string $oldStatus,
        string|OrderStatus $newStatus,
        Order $order
    ): void {
        $newStatus = $newStatus instanceof OrderStatus ? $newStatus->value : $newStatus;

        if ($oldStatus !== $newStatus) {
            switch ($newStatus) {
                case OrderStatus::SUCCESS->value:
                    Ordered::dispatch($order);
                    break;
            }
        }
    }

    public function refreshOrder(CartDto $cartDto, Order $order): TotalsDto
    {
        $existingProductIds = $order->items->pluck('one_time_product_id')->toArray();
        $newProductIds = [];
        foreach ($cartDto->items as $item) {
            $newProductIds[] = $item->productId;
        }

        $cartProductToQuantity = [];
        foreach ($cartDto->items as $item) {
            $cartProductToQuantity[$item->productId] = $item->quantity;
        }

        $productIdsToAdd = array_diff($newProductIds, $existingProductIds);
        $productIdsToRemove = array_diff($existingProductIds, $newProductIds);
        $productsToUpdate = array_intersect($existingProductIds, $newProductIds);
        $productsToAdd = OneTimeProduct::whereIn('id', $productIdsToAdd)->get();

        $totals = new TotalsDto();

        DB::transaction(function () use ($order, $productIdsToRemove, $productsToAdd, $cartDto, &$totals, $cartProductToQuantity, $productsToUpdate) {

            foreach ($productIdsToRemove as $productId) {
                $order->items()->where('one_time_product_id', $productId)->delete();
            }

            foreach ($productsToAdd as $product) {
                $order->items()->create([
                    'one_time_product_id' => $product->id,
                    'quantity' => $cartProductToQuantity[$product->id],
                    'price_per_unit' => 0,
                ]);
            }

            foreach ($productsToUpdate as $productId) {
                $orderItem = $order->items()->where('one_time_product_id', $productId)->first();
                $orderItem->quantity = $cartProductToQuantity[$productId];
                $orderItem->save();
            }

            $order->save();

            $order->refresh();

            $totals = $this->calculationManager->calculateOrderTotals($order, auth()->user(), $cartDto->discountCode);

            $order->save();
        });

        return $totals;
    }

    public function findNewForUser(int $userId): ?Order
    {
        return Order::where('user_id', $userId)
            ->where('status', OrderStatus::NEW)
            ->first();
    }
}
