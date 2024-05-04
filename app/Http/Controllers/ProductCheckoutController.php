<?php

namespace App\Http\Controllers;

use App\Constants\SessionConstants;
use App\Dto\CartDto;
use App\Dto\CartItemDto;
use App\Services\CalculationManager;
use App\Services\DiscountManager;
use App\Services\OneTimeProductManager;
use App\Services\PaymentProviders\PaymentManager;
use Illuminate\Http\Request;

class ProductCheckoutController extends Controller
{
    public function __construct(
        private PaymentManager $paymentManager,
        private DiscountManager $discountManager,
        private OneTimeProductManager $productManager,
        private CalculationManager $calculationManager,
    ) {

    }

    public function productCheckout(Request $request)
    {
        $cartDto = $this->getCartDto();

        if (empty($cartDto->items)) {
            return redirect()->route('home');
        }

        $product = $this->productManager->getOneTimeProductById($cartDto->items[0]->productId);

        $totals = $this->calculationManager->calculateCartTotals($cartDto, auth()->user());

        $this->saveCartDto($cartDto);

        $paymentProviders = $this->paymentManager->getActivePaymentProviders();

        return view('checkout.product', [
            'product' => $product,
            'paymentProviders' => $paymentProviders,
            'totals' => $totals,
            'cartDto' => $cartDto,
            'successUrl' => route('checkout.product.success'),
        ]);
    }

    public function addToCart(string $productSlug, int $quantity = 1)
    {
        $cartDto = $this->clearCartDto();  // use getCartDto() instead of clearCartDto() when allowing full cart checkout with multiple items

        $product = $this->productManager->getProductWithPriceBySlug($productSlug);

        if ($product === null) {
            abort(404);
        }

        if (! $product->is_active) {
            abort(404);
        }

        if ($quantity < 1) {
            $quantity = 1;
        }

        if ($quantity > $product->max_quantity) {
            $quantity = $product->max_quantity;
        }

        // if product is already in cart, increase quantity
        foreach ($cartDto->items as $item) {
            if ($item->productId == $product->id) {
                $item->quantity += $quantity;
                $item->quantity = min($item->quantity, $product->max_quantity);
                $this->saveCartDto($cartDto);

                return redirect()->route('checkout.product');
            }
        }

        $cartItem = new CartItemDto();
        $cartItem->productId = $product->id;
        $cartItem->quantity = $quantity;

        $cartDto->items[] = $cartItem;

        $this->saveCartDto($cartDto);

        return redirect()->route('checkout.product');
    }

    public function productCheckoutSuccess()
    {
        $cartDto = $this->getCartDto();

        if ($cartDto->orderId === null) {
            return redirect()->route('home');
        }

        if ($cartDto->discountCode !== null) {
            $this->discountManager->redeemCodeForOrder($cartDto->discountCode, auth()->user(), $cartDto->orderId);
        }

        $this->clearCartDto();

        return view('checkout.product-thank-you');
    }

    private function getCartDto(): CartDto
    {
        return session()->get(SessionConstants::CART_DTO) ?? new CartDto();
    }

    private function saveCartDto(CartDto $cartDto): void
    {
        session()->put(SessionConstants::CART_DTO, $cartDto);
    }

    private function clearCartDto(): CartDto
    {
        session()->forget(SessionConstants::CART_DTO);

        return new CartDto();
    }

    public function clearCart()
    {
        $this->clearCartDto();

        return redirect()->route('home');
    }
}
