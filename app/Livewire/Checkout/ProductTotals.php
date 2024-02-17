<?php

namespace App\Livewire\Checkout;

use App\Constants\SessionConstants;
use App\Dto\CartDto;
use App\Dto\TotalsDto;
use App\Models\OneTimeProduct;
use App\Models\Order;
use App\Services\CalculationManager;
use App\Services\DiscountManager;
use Livewire\Component;

class ProductTotals extends Component
{
    public $page;
    public $order;
    public $subtotal;
    public $product;
    public $discountAmount;
    public $amountDue;
    public $currencyCode;
    public $code;

    private DiscountManager $discountManager;
    private CalculationManager $calculationManager;

    public function boot(DiscountManager $discountManager, CalculationManager $calculationManager)
    {
        $this->discountManager = $discountManager;
        $this->calculationManager = $calculationManager;
    }

    public function mount(TotalsDto $totals, Order $order, OneTimeProduct $product, $page)
    {
        $this->page = $page;
        $this->order = $order;
        $this->product = $product;
        $this->totals = $totals;
        $this->subtotal = $totals->subtotal;
        $this->discountAmount = $totals->discountAmount;
        $this->amountDue = $totals->amountDue;
        $this->currencyCode = $totals->currencyCode;
    }

    private function getCartDto(): ?CartDto
    {
        return session()->get(SessionConstants::CART_DTO);
    }

    private function saveCartDto(CartDto $cartDto): void
    {
        session()->put(SessionConstants::CART_DTO, $cartDto);
    }

    public function add()
    {
        $code = $this->code;

        if ($code === null) {
            session()->flash('error', __('Please enter a discount code.'));
            return;
        }

        $isRedeemable = $this->discountManager->isCodeRedeemableForOneTimeProduct($code, auth()->user(), $this->product);

        if (!$isRedeemable) {
            session()->flash('error', __('This discount code is invalid.'));
            return;
        }

        $cartDto = $this->getCartDto();
        $cartDto->discountCode = $code;

        $this->saveCartDto($cartDto);

        $this->updateTotals();

        session()->flash('success', __('The discount code has been applied.'));

        return redirect($this->page);  // we have to redirect to the same page as payment provider init has to be done again (which is done on checkout page load)
    }

    public function remove()
    {
        $cartDto = $this->getCartDto();
        $cartDto->discountCode = null;
        $this->saveCartDto($cartDto);

        session()->flash('success', __('The discount code has been removed.'));

        $this->updateTotals();

        return redirect($this->page);  // we have to redirect to the same page as payment provider init has to be done again (which is done on checkout page load)
    }

    protected function updateTotals()
    {
        $cartDto = $this->getCartDto();
        $totals = $this->calculationManager->calculateOrderTotals(
            $this->order,
            auth()->user(),
            $cartDto->discountCode
        );

        $this->subtotal = $totals->subtotal;
        $this->discountAmount = $totals->discountAmount;
        $this->amountDue = $totals->amountDue;
        $this->currencyCode = $totals->currencyCode;
    }

    public function render()
    {
        return view('livewire.checkout.product-totals', [
            'addedCode' => $this->getCartDto()->discountCode,
        ]);
    }
}
