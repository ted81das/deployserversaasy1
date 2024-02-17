<?php

namespace App\Http\Controllers;

use App\Constants\SessionConstants;
use App\Dto\CartDto;
use App\Dto\CartItemDto;
use App\Services\CheckoutManager;
use App\Services\DiscountManager;
use App\Services\OneTimeProductManager;
use App\Services\PaymentProviders\PaymentManager;
use App\Services\PaymentProviders\PaymentProviderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductCheckoutController extends Controller
{
    public function __construct(
        private CheckoutManager    $checkoutManager,
        private PaymentManager     $paymentManager,
        private DiscountManager    $discountManager,
        private OneTimeProductManager $productManager,
    ) {

    }

    public function productCheckout(Request $request)
    {
        $cartDto = $this->getCartDto();

        if (empty($cartDto->items)) {
            return redirect()->route('home');
        }

        list($order, $totals) = $this->checkoutManager->initProductCheckout($cartDto);

        $cartDto->orderId = $order->id;
        $this->saveCartDto($cartDto);

        $discount = null;
        if ($cartDto->discountCode !== null) {
            $discount = $this->discountManager->getActiveDiscountByCode($cartDto->discountCode);
        }

        if ($request->isMethod('post')) {

            $paymentProvider = $this->paymentManager->getPaymentProviderBySlug(
                $request->get('payment-provider')
            );

            $link = $paymentProvider->createProductCheckoutRedirectLink(
                $order,
                $discount,
            );

            return redirect()->away($link);
        }

        $paymentProviders = $this->paymentManager->getActivePaymentProviders();

        $initializedPaymentProviders = [];
        $providerInitData = [];
        /** @var PaymentProviderInterface $paymentProvider */
        foreach ($paymentProviders as $paymentProvider) {
            try {
                $providerInitData[$paymentProvider->getSlug()] = $paymentProvider->initProductCheckout($order, $discount);
                $initializedPaymentProviders[] = $paymentProvider;
            } catch (\Exception $e) {
                Log::error($e->getMessage(), [
                    'exception' => $e,
                ]);
            }
        }

        return view('checkout.product', [
            'paymentProviders' => $initializedPaymentProviders,
            'providerInitData' => $providerInitData,
            'order' => $order,
            'totals' => $totals,
            'cartDto' => $cartDto,
            'successUrl' => route('checkout.product.success'),
            'user' => auth()->user(),
        ]);
    }

    public function addToCart(string $productSlut, int $quantity = 1)
    {
        $cartDto = $this->getCartDto();  // use getCartDto() instead of clearCartDto() when allowing full cart checkout with multiple items

        $product = $this->productManager->getProductWithPriceBySlug($productSlut);

        if ($product === null) {
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

                return response()->json([
                    'success' => true,
                ]);
            }
        }

        $cartItem = new CartItemDto();
        $cartItem->productId = $product->id;
        $cartItem->quantity = $quantity;

        $cartDto->items[] = $cartItem;

        $this->saveCartDto($cartDto);

        return response()->json([
            'success' => true,
        ]);
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
