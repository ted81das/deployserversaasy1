<?php

namespace Tests\Feature\Http\Controllers\PaymentProviders;

use App\Constants\SubscriptionStatus;
use App\Constants\TransactionStatus;
use App\Models\PaymentProvider;
use App\Models\Subscription;
use App\Services\PaymentProviders\Stripe\StripeWebhookHandler;
use App\Services\SubscriptionManager;
use App\Services\TransactionManager;
use Illuminate\Support\Str;
use Mockery\MockInterface;
use Tests\Feature\FeatureTest;

class StripeControllerTest extends FeatureTest
{
    public function test_subscription_created_webhook(): void
    {
        $uuid = (string) Str::uuid();
        Subscription::create([
            'uuid' => $uuid,
            'user_id' => 1,
            'price' => 10,
            'currency_id' => 1,
            'plan_id' => 1,
            'interval_id' => 2,
            'interval_count' => 1,
            'status' => SubscriptionStatus::NEW->value,
        ]);

        $payload = $this->getStripeSubscription('incomplete', 'customer.subscription.created', $uuid);

        $timestamp = time();
        $payloadString = json_encode($payload);
        $signature = \hash_hmac('sha256', "{$timestamp}.{$payloadString}", config('services.stripe.webhook_signing_secret'));

        $response = $this->postJson(route('payments-providers.stripe.webhook'), $payload, [
            'Stripe-Signature' => 't=' . $timestamp . ',v1=' . $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscriptions', [
            'uuid' => $uuid,
            'status' => SubscriptionStatus::INACTIVE->value,
        ]);
    }

    public function test_subscription_updated_webhook(): void
    {
        $uuid = (string) Str::uuid();
        Subscription::create([
            'uuid' => $uuid,
            'user_id' => 1,
            'price' => 10,
            'currency_id' => 1,
            'plan_id' => 1,
            'interval_id' => 2,
            'interval_count' => 1,
            'status' => SubscriptionStatus::INACTIVE->value,
        ]);

        $payload = $this->getStripeSubscription('active', 'customer.subscription.updated', $uuid);

        $timestamp = time();
        $payloadString = json_encode($payload);
        $signature = \hash_hmac('sha256', "{$timestamp}.{$payloadString}", config('services.stripe.webhook_signing_secret'));

        $response = $this->postJson(route('payments-providers.stripe.webhook'), $payload, [
            'Stripe-Signature' => 't=' . $timestamp . ',v1=' . $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscriptions', [
            'uuid' => $uuid,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);
    }

    public function test_subscription_deleted_webhook(): void
    {
        $uuid = (string) Str::uuid();
        Subscription::create([
            'uuid' => $uuid,
            'user_id' => 1,
            'price' => 10,
            'currency_id' => 1,
            'plan_id' => 1,
            'interval_id' => 2,
            'interval_count' => 1,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);

        $payload = $this->getStripeSubscription('canceled', 'customer.subscription.deleted', $uuid);

        $timestamp = time();
        $payloadString = json_encode($payload);
        $signature = \hash_hmac('sha256', "{$timestamp}.{$payloadString}", config('services.stripe.webhook_signing_secret'));

        $response = $this->postJson(route('payments-providers.stripe.webhook'), $payload, [
            'Stripe-Signature' => 't=' . $timestamp . ',v1=' . $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscriptions', [
            'uuid' => $uuid,
            'status' => SubscriptionStatus::CANCELED->value,
        ]);
    }

    public function test_subscription_paused_webhook(): void
    {
        $uuid = (string) Str::uuid();
        Subscription::create([
            'uuid' => $uuid,
            'user_id' => 1,
            'price' => 10,
            'currency_id' => 1,
            'plan_id' => 1,
            'interval_id' => 2,
            'interval_count' => 1,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);

        $payload = $this->getStripeSubscription('paused', 'customer.subscription.paused', $uuid);

        $timestamp = time();
        $payloadString = json_encode($payload);
        $signature = \hash_hmac('sha256', "{$timestamp}.{$payloadString}", config('services.stripe.webhook_signing_secret'));

        $response = $this->postJson(route('payments-providers.stripe.webhook'), $payload, [
            'Stripe-Signature' => 't=' . $timestamp . ',v1=' . $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscriptions', [
            'uuid' => $uuid,
            'status' => SubscriptionStatus::PAUSED->value,
        ]);
    }

    public function test_subscription_resumed_webhook(): void
    {
        $uuid = (string) Str::uuid();
        Subscription::create([
            'uuid' => $uuid,
            'user_id' => 1,
            'price' => 10,
            'currency_id' => 1,
            'plan_id' => 1,
            'interval_id' => 2,
            'interval_count' => 1,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);

        $payload = $this->getStripeSubscription('active', 'customer.subscription.resumed', $uuid);

        $timestamp = time();
        $payloadString = json_encode($payload);
        $signature = \hash_hmac('sha256', "{$timestamp}.{$payloadString}", config('services.stripe.webhook_signing_secret'));

        $response = $this->postJson(route('payments-providers.stripe.webhook'), $payload, [
            'Stripe-Signature' => 't=' . $timestamp . ',v1=' . $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscriptions', [
            'uuid' => $uuid,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);
    }

    public function test_invoice_created_webhook(): void
    {
        $uuid = (string) Str::uuid();
        $subscription = Subscription::create([
            'uuid' => $uuid,
            'user_id' => 1,
            'price' => 10,
            'currency_id' => 1,
            'plan_id' => 1,
            'interval_id' => 2,
            'interval_count' => 1,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);

        $invoiceId = Str::random();
        $payload = $this->getStripeInvoice('open', 'invoice.created', $uuid, $invoiceId);

        $timestamp = time();
        $payloadString = json_encode($payload);
        $signature = \hash_hmac('sha256', "{$timestamp}.{$payloadString}", config('services.stripe.webhook_signing_secret'));

        $response = $this->postJson(route('payments-providers.stripe.webhook'), $payload, [
            'Stripe-Signature' => 't=' . $timestamp . ',v1=' . $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('transactions', [
            'subscription_id' => $subscription->id,
            'status' => TransactionStatus::NOT_STARTED->value,
            'payment_provider_transaction_id' => $invoiceId,
            'payment_provider_status' => 'open',
        ]);
    }

    public function test_invoice_updated_webhook(): void
    {
        $uuid = (string) Str::uuid();
        $subscription = Subscription::create([
            'uuid' => $uuid,
            'user_id' => 1,
            'price' => 10,
            'currency_id' => 1,
            'plan_id' => 1,
            'interval_id' => 2,
            'interval_count' => 1,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);

        $invoiceId = Str::random();

        $transaction = $subscription->transactions()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $subscription->user_id,
            'currency_id' => $subscription->currency_id,
            'amount' => $subscription->price,
            'status' => TransactionStatus::NOT_STARTED->value,
            'subscription_id' => $subscription->id,
            'payment_provider_id' => PaymentProvider::where('slug', 'stripe')->firstOrFail()->id,
            'payment_provider_status' => 'open',
            'payment_provider_transaction_id' => $invoiceId,
        ]);

        $payload = $this->getStripeInvoice(
            'paid',
            'invoice.updated',
            $uuid,
            $invoiceId,
        );

        $timestamp = time();
        $payloadString = json_encode($payload);
        $signature = \hash_hmac('sha256', "{$timestamp}.{$payloadString}", config('services.stripe.webhook_signing_secret'));

        $mock = \Mockery::mock(StripeWebhookHandler::class, [resolve(SubscriptionManager::class), resolve(TransactionManager::class)])->makePartial()->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive('calculateFees')->once()->andReturn(0);
        $this->app->instance(StripeWebhookHandler::class, $mock);

        $response = $this->postJson(route('payments-providers.stripe.webhook'), $payload, [
            'Stripe-Signature' => 't=' . $timestamp . ',v1=' . $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('transactions', [
            'subscription_id' => $subscription->id,
            'status' => TransactionStatus::SUCCESS->value,
            'payment_provider_transaction_id' => $invoiceId,
            'payment_provider_status' => 'paid',
        ]);
    }

    public function test_invoice_paid_webhook(): void
    {
        $uuid = (string) Str::uuid();
        $subscription = Subscription::create([
            'uuid' => $uuid,
            'user_id' => 1,
            'price' => 10,
            'currency_id' => 1,
            'plan_id' => 1,
            'interval_id' => 2,
            'interval_count' => 1,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);

        $invoiceId = Str::random();

        $transaction = $subscription->transactions()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $subscription->user_id,
            'currency_id' => $subscription->currency_id,
            'amount' => $subscription->price,
            'status' => TransactionStatus::NOT_STARTED->value,
            'subscription_id' => $subscription->id,
            'payment_provider_id' => PaymentProvider::where('slug', 'stripe')->firstOrFail()->id,
            'payment_provider_status' => 'open',
            'payment_provider_transaction_id' => $invoiceId,
        ]);

        $payload = $this->getStripeInvoice(
            'paid',
            'invoice.paid',
            $uuid,
            $invoiceId,
        );

        $timestamp = time();
        $payloadString = json_encode($payload);
        $signature = \hash_hmac('sha256', "{$timestamp}.{$payloadString}", config('services.stripe.webhook_signing_secret'));

        $mock = \Mockery::mock(StripeWebhookHandler::class, [resolve(SubscriptionManager::class), resolve(TransactionManager::class)])->makePartial()->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive('calculateFees')->once()->andReturn(0);
        $this->app->instance(StripeWebhookHandler::class, $mock);

        $response = $this->postJson(route('payments-providers.stripe.webhook'), $payload, [
            'Stripe-Signature' => 't=' . $timestamp . ',v1=' . $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('transactions', [
            'subscription_id' => $subscription->id,
            'status' => TransactionStatus::SUCCESS->value,
            'payment_provider_transaction_id' => $invoiceId,
            'payment_provider_status' => 'paid',
        ]);
    }

    public function test_invoice_payment_failed_webhook(): void
    {
        $uuid = (string) Str::uuid();
        $subscription = Subscription::create([
            'uuid' => $uuid,
            'user_id' => 1,
            'price' => 10,
            'currency_id' => 1,
            'plan_id' => 1,
            'interval_id' => 2,
            'interval_count' => 1,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);

        $invoiceId = Str::random();

        $transaction = $subscription->transactions()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $subscription->user_id,
            'currency_id' => $subscription->currency_id,
            'amount' => $subscription->price,
            'status' => TransactionStatus::NOT_STARTED->value,
            'subscription_id' => $subscription->id,
            'payment_provider_id' => PaymentProvider::where('slug', 'stripe')->firstOrFail()->id,
            'payment_provider_status' => 'open',
            'payment_provider_transaction_id' => $invoiceId,
        ]);

        $payload = $this->getStripeInvoice(
            'void',
            'invoice.payment_failed',
            $uuid,
            $invoiceId,
        );

        $timestamp = time();
        $payloadString = json_encode($payload);
        $signature = \hash_hmac('sha256', "{$timestamp}.{$payloadString}", config('services.stripe.webhook_signing_secret'));

        $response = $this->postJson(route('payments-providers.stripe.webhook'), $payload, [
            'Stripe-Signature' => 't=' . $timestamp . ',v1=' . $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('transactions', [
            'subscription_id' => $subscription->id,
            'status' => TransactionStatus::FAILED->value,
            'payment_provider_transaction_id' => $invoiceId,
            'payment_provider_status' => 'void',
        ]);
    }

    public function test_invoice_payment_action_required_webhook(): void
    {
        $uuid = (string) Str::uuid();
        $subscription = Subscription::create([
            'uuid' => $uuid,
            'user_id' => 1,
            'price' => 10,
            'currency_id' => 1,
            'plan_id' => 1,
            'interval_id' => 2,
            'interval_count' => 1,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);

        $invoiceId = Str::random();

        $transaction = $subscription->transactions()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $subscription->user_id,
            'currency_id' => $subscription->currency_id,
            'amount' => $subscription->price,
            'status' => TransactionStatus::NOT_STARTED->value,
            'subscription_id' => $subscription->id,
            'payment_provider_id' => PaymentProvider::where('slug', 'stripe')->firstOrFail()->id,
            'payment_provider_status' => 'open',
            'payment_provider_transaction_id' => $invoiceId,
        ]);

        $payload = $this->getStripeInvoice(
            'pending',
            'invoice.payment_action_required',
            $uuid,
            $invoiceId,
        );

        $timestamp = time();
        $payloadString = json_encode($payload);
        $signature = \hash_hmac('sha256', "{$timestamp}.{$payloadString}", config('services.stripe.webhook_signing_secret'));

        $response = $this->postJson(route('payments-providers.stripe.webhook'), $payload, [
            'Stripe-Signature' => 't=' . $timestamp . ',v1=' . $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('transactions', [
            'subscription_id' => $subscription->id,
            'status' => TransactionStatus::PENDING->value,
            'payment_provider_transaction_id' => $invoiceId,
            'payment_provider_status' => 'pending',
        ]);
    }

    private function getStripeInvoice(
        string $stripeInvoiceStatus,
        string $type,
        string $subscriptionUuid,
        string $invoiceId,
    ) {
        $json = <<<JSON
          {
          "type": "$type",
          "id": "evt_1J5X2n2eZvKYlo2C0Q2Z2Z2Z",
          "object": "event",
          "api_version": "2020-08-27",
          "created": 1632830000,
          "data": {
              "object": {
                "id": "$invoiceId",
                "object": "invoice",
                "account_country": "DE",
                "account_name": null,
                "account_tax_ids": null,
                "amount_due": 1100,
                "amount_paid": 0,
                "amount_remaining": 1100,
                "amount_shipping": 0,
                "application": null,
                "application_fee_amount": null,
                "attempt_count": 0,
                "attempted": false,
                "auto_advance": false,
                "automatic_tax": {
                  "enabled": false,
                  "status": null
                },
                "billing_reason": "subscription_create",
                "charge": null,
                "collection_method": "charge_automatically",
                "created": 1693839788,
                "currency": "usd",
                "custom_fields": null,
                "customer": "cus_OVg036aoJZPtXL",
                "customer_address": null,
                "customer_email": "test@gmail.com",
                "customer_name": "Booh",
                "customer_phone": null,
                "customer_shipping": null,
                "customer_tax_exempt": "none",
                "customer_tax_ids": [
                ],
                "default_payment_method": null,
                "default_source": null,
                "default_tax_rates": [
                ],
                "description": null,
                "discount": null,
                "discounts": [
                ],
                "due_date": null,
                "effective_at": 1693839788,
                "ending_balance": 0,
                "footer": null,
                "from_invoice": null,
                "hosted_invoice_url": "https://invoice.stripe.com/i/acct_1NheKTJQC7CL5JsV/test_YWNjdF8xTmhlS1RKUUM3Q0w1SnNWLF9PWm51R1JpYk1DODd1ZWZTTlg4NGE1Q1JVVDljT2JhLDg0MzgwNTkx0200Iscx1aj0?s=ap",
                "invoice_pdf": "https://pay.stripe.com/invoice/acct_1NheKTJQC7CL5JsV/test_YWNjdF8xTmhlS1RKUUM3Q0w1SnNWLF9PWm51R1JpYk1DODd1ZWZTTlg4NGE1Q1JVVDljT2JhLDg0MzgwNTkx0200Iscx1aj0/pdf?s=ap",
                "last_finalization_error": null,
                "latest_revision": null,
                "lines": {
                  "object": "list",
                  "data": [
                    {
                      "id": "il_1NmeIyJQC7CL5JsViY2FMHaT",
                      "object": "line_item",
                      "amount": 1100,
                      "amount_excluding_tax": 1100,
                      "currency": "usd",
                      "description": "1 × Monthly AI Images (at $11.00 / month)",
                      "discount_amounts": [
                      ],
                      "discountable": true,
                      "discounts": [
                      ],
                      "livemode": false,
                      "metadata": {
                        "subscription_uuid": "756fa6a0-0ab9-4023-b732-1b52e7d86e0e"
                      },
                      "period": {
                        "end": 1696431788,
                        "start": 1693839788
                      },
                      "plan": {
                        "id": "price_1NmeIvJQC7CL5JsVCJpxbS9L",
                        "object": "plan",
                        "active": false,
                        "aggregate_usage": null,
                        "amount": 1100,
                        "amount_decimal": "1100",
                        "billing_scheme": "per_unit",
                        "created": 1693839785,
                        "currency": "usd",
                        "interval": "month",
                        "interval_count": 1,
                        "livemode": false,
                        "metadata": {
                        },
                        "nickname": null,
                        "product": "sdf",
                        "tiers_mode": null,
                        "transform_usage": null,
                        "trial_period_days": null,
                        "usage_type": "licensed"
                      },
                      "price": {
                        "id": "price_1NmeIvJQC7CL5JsVCJpxbS9L",
                        "object": "price",
                        "active": false,
                        "billing_scheme": "per_unit",
                        "created": 1693839785,
                        "currency": "usd",
                        "custom_unit_amount": null,
                        "livemode": false,
                        "lookup_key": null,
                        "metadata": {
                        },
                        "nickname": null,
                        "product": "sdf",
                        "recurring": {
                          "aggregate_usage": null,
                          "interval": "month",
                          "interval_count": 1,
                          "trial_period_days": null,
                          "usage_type": "licensed"
                        },
                        "tax_behavior": "unspecified",
                        "tiers_mode": null,
                        "transform_quantity": null,
                        "type": "recurring",
                        "unit_amount": 1100,
                        "unit_amount_decimal": "1100"
                      },
                      "proration": false,
                      "proration_details": {
                        "credited_items": null
                      },
                      "quantity": 1,
                      "subscription": "sub_1NmeIyJQC7CL5JsVTf7ApLga",
                      "subscription_item": "si_OZnu0wgSk4Dzq1",
                      "tax_amounts": [
                      ],
                      "tax_rates": [
                      ],
                      "type": "subscription",
                      "unit_amount_excluding_tax": "1100"
                    }
                  ],
                  "has_more": false,
                  "total_count": 1,
                  "url": "/v1/invoices/in_1NmeIyJQC7CL5JsVsjFfiXIF/lines"
                },
                "livemode": false,
                "metadata": {
                },
                "next_payment_attempt": null,
                "number": "A10DDDFF-0004",
                "on_behalf_of": null,
                "paid": false,
                "paid_out_of_band": false,
                "payment_intent": "pi_3NmeIyJQC7CL5JsV0VXzUaBM",
                "payment_settings": {
                  "default_mandate": null,
                  "payment_method_options": null,
                  "payment_method_types": null
                },
                "period_end": 1693839788,
                "period_start": 1693839788,
                "post_payment_credit_notes_amount": 0,
                "pre_payment_credit_notes_amount": 0,
                "quote": null,
                "receipt_number": null,
                "rendering_options": null,
                "shipping_cost": null,
                "shipping_details": null,
                "starting_balance": 0,
                "statement_descriptor": null,
                "status": "$stripeInvoiceStatus",
                "status_transitions": {
                  "finalized_at": 1693839788,
                  "marked_uncollectible_at": null,
                  "paid_at": null,
                  "voided_at": null
                },
                "subscription": "sub_1NmeIyJQC7CL5JsVTf7ApLga",
                "subscription_details": {
                  "metadata": {
                    "subscription_uuid": "$subscriptionUuid"
                  }
                },
                "subtotal": 1100,
                "subtotal_excluding_tax": 1100,
                "tax": null,
                "test_clock": null,
                "total": 1100,
                "total_discount_amounts": [
                ],
                "total_excluding_tax": 1100,
                "total_tax_amounts": [
                ],
                "transfer_data": null,
                "webhooks_delivered_at": null
              }
            }
          }
JSON;

        return json_decode($json, true);
    }

    private function getStripeSubscription(
        string $stripeSubscriptionStatus,
        string $type,
        string $subscriptionUuid,
    ) {
        $json = <<<JSON
        {
          "type": "$type",
          "id": "evt_1J5X2n2eZvKYlo2C0Q2Z2Z2Z",
          "object": "event",
          "api_version": "2020-08-27",
          "created": 1632830000,
          "data": {
              "object": {
                "id": "sub_1NnOIdJQC7CL5JsVPmRlNlsR",
                "object": "subscription",
                "currency": "usd",
                "canceled_at": null,
                "current_period_end": 1696608591,
                "current_period_start": 1694016591,
                "customer": "cus_OVg036aoJZPtXL",
                "ended_at": null,
                "items": {
                  "object": "list",
                  "data": [
                    {
                      "id": "si_OaZRwnUL1ruAJV",
                      "object": "subscription_item",
                      "billing_thresholds": null,
                      "created": 1694016591,
                      "metadata": {
                        "subscription_uuid": "756fa6a0-0ab9-4023-b732-1b52e7d86e0e"
                      },
                      "plan": {
                        "id": "price_1NnOIaJQC7CL5JsVT9G8URTq",
                        "object": "plan",
                        "active": false,
                        "aggregate_usage": null,
                        "amount": 1100,
                        "amount_decimal": "1100",
                        "billing_scheme": "per_unit",
                        "created": 1694016588,
                        "currency": "usd",
                        "interval": "month",
                        "interval_count": 1,
                        "livemode": false,
                        "metadata": {
                        },
                        "nickname": null,
                        "product": "sdf",
                        "tiers_mode": null,
                        "transform_usage": null,
                        "trial_period_days": null,
                        "usage_type": "licensed"
                      },
                      "price": {
                        "id": "price_1NnOIaJQC7CL5JsVT9G8URTq",
                        "object": "price",
                        "active": false,
                        "billing_scheme": "per_unit",
                        "created": 1694016588,
                        "currency": "usd",
                        "custom_unit_amount": null,
                        "livemode": false,
                        "lookup_key": null,
                        "metadata": {
                        },
                        "nickname": null,
                        "product": "sdf",
                        "recurring": {
                          "aggregate_usage": null,
                          "interval": "month",
                          "interval_count": 1,
                          "trial_period_days": null,
                          "usage_type": "licensed"
                        },
                        "tax_behavior": "unspecified",
                        "tiers_mode": null,
                        "transform_quantity": null,
                        "type": "recurring",
                        "unit_amount": 1100,
                        "unit_amount_decimal": "1100"
                      },
                      "quantity": 1,
                      "subscription": "sub_1NnOIdJQC7CL5JsVPmRlNlsR",
                      "tax_rates": [
                      ]
                    }
                  ],
                  "has_more": false,
                  "total_count": 1,
                  "url": "/v1/subscription_items?subscription=sub_1NnOIdJQC7CL5JsVPmRlNlsR"
                },
                "latest_invoice": "in_1NnOIdJQC7CL5JsVMDKMZOlI",
                "livemode": false,
                "metadata": {
                  "subscription_uuid": "$subscriptionUuid"
                },
                "next_pending_invoice_item_invoice": null,
                "on_behalf_of": null,
                "pause_collection": null,
                "payment_settings": {
                  "payment_method_options": null,
                  "payment_method_types": null,
                  "save_default_payment_method": "off"
                },
                "pending_invoice_item_interval": null,
                "pending_setup_intent": null,
                "pending_update": null,
                "plan": {
                  "id": "price_1NnOIaJQC7CL5JsVT9G8URTq",
                  "object": "plan",
                  "active": false,
                  "aggregate_usage": null,
                  "amount": 1100,
                  "amount_decimal": "1100",
                  "billing_scheme": "per_unit",
                  "created": 1694016588,
                  "currency": "usd",
                  "interval": "month",
                  "interval_count": 1,
                  "livemode": false,
                  "metadata": {
                  },
                  "nickname": null,
                  "product": "sdf",
                  "tiers_mode": null,
                  "transform_usage": null,
                  "trial_period_days": null,
                  "usage_type": "licensed"
                },
                "quantity": 1,
                "schedule": null,
                "start_date": 1694016591,
                "status": "$stripeSubscriptionStatus",
                "test_clock": null,
                "transfer_data": null,
                "trial_end": null,
                "trial_settings": {
                  "end_behavior": {
                    "missing_payment_method": "create_invoice"
                  }
                },
                "trial_start": null
              }
            }
          }
JSON;

        return json_decode($json, true);
    }
}
