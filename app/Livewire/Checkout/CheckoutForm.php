<?php

namespace App\Livewire\Checkout;

use App\Constants\SessionConstants;
use App\Dto\CartDto;
use App\Models\User;
use App\Services\CheckoutManager;
use App\Services\DiscountManager;
use App\Services\OneTimeProductManager;
use App\Services\PaymentProviders\PaymentManager;
use App\Services\UserManager;
use App\Validator\LoginValidator;
use App\Validator\RegisterValidator;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CheckoutForm extends Component
{
    public $intro;

    public $name;

    public $email;

    public $password;

    public $paymentProvider;

    public $recaptcha;

    private $paymentProviders = [];

    public function mount(string $intro = '')
    {
        $this->intro = $intro;
    }

    public function render(PaymentManager $paymentManager)
    {
        return view('livewire.checkout.checkout-form', [
            'userExists' => $this->userExists($this->email),
            'paymentProviders' => $this->getPaymentProviders($paymentManager),
        ]);
    }

    public function checkout(
        LoginValidator $loginValidator,
        RegisterValidator $registerValidator,
        CheckoutManager $checkoutManager,
        PaymentManager $paymentManager,
        DiscountManager $discountManager,
        UserManager $userManager,
        OneTimeProductManager $oneTimeProductManager
    ) {
        if (! auth()->check()) {
            if ($this->userExists($this->email)) {
                $this->loginUser($loginValidator);
            } else {
                $this->registerUser($registerValidator, $userManager);
            }
        }

        $user = auth()->user();
        if (! $user) {
            $this->redirect(route('login'));
        }

        if ($user->is_blocked) {
            auth()->logout();
            throw ValidationException::withMessages([
                'email' => __('Your account is blocked, please contact support.'),
            ]);

            return;
        }

        $cartDto = $this->getCartDto();

        $order = $checkoutManager->initProductCheckout($cartDto);

        $cartDto->orderId = $order->id;

        $paymentProvider = $paymentManager->getPaymentProviderBySlug(
            $this->paymentProvider
        );

        $discount = null;
        if ($cartDto->discountCode !== null) {
            $discount = $discountManager->getActiveDiscountByCode($cartDto->discountCode);
            $product = $oneTimeProductManager->getOneTimeProductById($cartDto->items[0]->productId);

            if (! $discountManager->isCodeRedeemableForOneTimeProduct($cartDto->discountCode, auth()->user(), $product)) {
                // this is to handle the case when user adds discount code that has max redemption limit per customer,
                // then logs-in during the checkout process and the discount code is not valid anymore
                $cartDto->discountCode = null;
                $discount = null;
                $this->dispatch('calculations-updated')->to(ProductTotals::class);
            }
        }

        $initData = $paymentProvider->initProductCheckout($order, $discount);

        $this->saveCartDto($cartDto);

        $user = auth()->user();

        if ($paymentProvider->isRedirectProvider()) {
            $link = $paymentProvider->createProductCheckoutRedirectLink(
                $order,
                $discount,
            );
        } else {
            $this->dispatch('start-overlay-checkout',
                paymentProvider: $paymentProvider->getSlug(),
                initData: $initData,
                successUrl: route('checkout.product.success'),
                email: $user->email,
                orderUuid: $order->uuid,
            );

            return;
        }

        return redirect()->away($link);

    }

    private function getCartDto(): ?CartDto
    {
        return session()->get(SessionConstants::CART_DTO);
    }

    private function saveCartDto(CartDto $cartDto): void
    {
        session()->put(SessionConstants::CART_DTO, $cartDto);
    }

    private function loginUser(LoginValidator $loginValidator)
    {
        $fields = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (config('app.recaptcha_enabled')) {
            $fields[recaptchaFieldName()] = $this->recaptcha;
        }

        $validator = $loginValidator->validate($fields);

        if ($validator->fails()) {
            $this->resetReCaptcha();
            throw new ValidationException($validator);
        }

        $result = auth()->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], true);

        if (! $result) {
            $this->resetReCaptcha();
            throw ValidationException::withMessages([
                'email' => __('Wrong email or password'),
            ]);
        }
    }

    private function registerUser(RegisterValidator $registerValidator, UserManager $userManager)
    {
        $fields = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (config('app.recaptcha_enabled')) {
            $fields[recaptchaFieldName()] = $this->recaptcha;
        }

        $validator = $registerValidator->validate($fields, false);

        if ($validator->fails()) {
            $this->resetReCaptcha();
            throw new ValidationException($validator);
        }

        $user = $userManager->createUser([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        auth()->login($user);

        return $user;
    }

    private function userExists(?string $email): bool
    {
        if ($email === null) {
            return false;
        }

        return User::where('email', $email)->exists();
    }

    private function getPaymentProviders(PaymentManager $paymentManager)
    {
        if (count($this->paymentProviders) > 0) {
            return $this->paymentProviders;
        }

        $this->paymentProviders = $paymentManager->getActivePaymentProviders();

        if (count($this->paymentProviders) > 0 && $this->paymentProvider === null) {
            $this->paymentProvider = $this->paymentProviders[0]->getSlug();
        }

        return $this->paymentProviders;
    }

    private function resetReCaptcha()
    {
        $this->dispatch('reset-recaptcha');
    }
}
