<?php

namespace Feature\Http\Controllers\PaymentProviders;

use App\Constants\SubscriptionStatus;
use App\Constants\TransactionStatus;
use App\Models\PaymentProvider;
use App\Models\Subscription;
use Illuminate\Support\Str;
use Tests\Feature\FeatureTest;

class PaddleControllerTest extends FeatureTest
{
    public function test_webhook_with_no_signature(): void
    {
        $response = $this->postJson(route('payments-providers.paddle.webhook'), [], [
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(400);
    }
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
            'interval_count' => 2,
            'status' => SubscriptionStatus::NEW->value,
        ]);

        $payload = $this->getPaddleSubscriptionEvent('trialing', 'subscription.created', $uuid);

        $signature = $this->generateSignature(json_encode($payload));

        $response = $this->postJson(route('payments-providers.paddle.webhook'), $payload, [
            'Paddle-Signature' => $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscriptions', [
            'uuid' => $uuid,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);
    }

    public function test_subscription_canceled_webhook(): void
    {
        $uuid = (string) Str::uuid();
        Subscription::create([
            'uuid' => $uuid,
            'user_id' => 1,
            'price' => 10,
            'currency_id' => 1,
            'plan_id' => 1,
            'interval_id' => 2,
            'interval_count' => 2,
            'status' => SubscriptionStatus::NEW->value,
        ]);

        $payload = $this->getPaddleSubscriptionEvent('canceled', 'subscription.canceled', $uuid);

        $signature = $this->generateSignature(json_encode($payload));

        $response = $this->postJson(route('payments-providers.paddle.webhook'), $payload, [
            'Paddle-Signature' => $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscriptions', [
            'uuid' => $uuid,
            'status' => SubscriptionStatus::CANCELED->value,
        ]);
    }

    public function test_transaction_created_webhook(): void
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

        $txnId = Str::random();
        $payload = $this->getPaddleTransaction('billed', 'transaction.created', $uuid, $txnId);

        $signature = $this->generateSignature(json_encode($payload));

        $response = $this->postJson(route('payments-providers.paddle.webhook'), $payload, [
            'Paddle-Signature' => $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('transactions', [
            'subscription_id' => $subscription->id,
            'status' => TransactionStatus::PENDING->value,
            'payment_provider_transaction_id' => $txnId,
            'payment_provider_status' => 'billed',
        ]);
    }

    public function test_transaction_updated_webhook(): void
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

        $txnId = Str::random();

        $transaction = $subscription->transactions()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $subscription->user_id,
            'currency_id' => $subscription->currency_id,
            'amount' => $subscription->price,
            'status' => TransactionStatus::PENDING->value,
            'subscription_id' => $subscription->id,
            'payment_provider_id' => PaymentProvider::where('slug', 'paddle')->firstOrFail()->id,
            'payment_provider_status' => 'open',
            'payment_provider_transaction_id' => $txnId,
        ]);

        $payload = $this->getPaddleTransaction('completed', 'transaction.updated', $uuid, $txnId);

        $signature = $this->generateSignature(json_encode($payload));

        $response = $this->postJson(route('payments-providers.paddle.webhook'), $payload, [
            'Paddle-Signature' => $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('transactions', [
            'subscription_id' => $subscription->id,
            'status' => TransactionStatus::SUCCESS->value,
            'payment_provider_transaction_id' => $txnId,
            'payment_provider_status' => 'completed',
        ]);
    }

    public function test_transaction_payment_failed_webhook(): void
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

        $txnId = Str::random();

        $transaction = $subscription->transactions()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $subscription->user_id,
            'currency_id' => $subscription->currency_id,
            'amount' => $subscription->price,
            'status' => TransactionStatus::PENDING->value,
            'subscription_id' => $subscription->id,
            'payment_provider_id' => PaymentProvider::where('slug', 'paddle')->firstOrFail()->id,
            'payment_provider_status' => 'open',
            'payment_provider_transaction_id' => $txnId,
        ]);

        $payload = $this->getPaddleTransaction('canceled', 'transaction.payment_failed', $uuid, $txnId);

        $signature = $this->generateSignature(json_encode($payload));

        $response = $this->postJson(route('payments-providers.paddle.webhook'), $payload, [
            'Paddle-Signature' => $signature,
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('transactions', [
            'subscription_id' => $subscription->id,
            'status' => TransactionStatus::FAILED->value,
            'payment_provider_transaction_id' => $txnId,
            'payment_provider_status' => 'canceled',
        ]);
    }

    private function generateSignature(string $content)
    {
        $time = time();
        $secret = config('services.paddle.webhook_secret');

        return 't=' . $time . ';h1=' . hash_hmac('sha256', $time . ':' . $content, $secret);
    }

    private function getPaddleTransaction(
        string $paddleTransactionStatus,
        string $type,
        string $subscriptionUuid,
        string $transactionId,
    ) {
        $json = <<<JSON
          {
              "event_id": "evt_01ha9zewxctz1375ren2d88t9n",
              "event_type": "$type",
              "occurred_at": "2023-09-14T13:53:02.380780Z",
              "notification_id": "ntf_01ha9zex2dytmzp45gxw3g85re",
              "data": {
                "id": "$transactionId",
                "items": [
                  {
                    "price": {
                      "id": "pri_01ha840zrqpwegbbvxafhtbqtk",
                      "status": "active",
                      "quantity": {
                        "maximum": 1,
                        "minimum": 1
                      },
                      "tax_mode": "account_setting",
                      "product_id": "pro_01ha32dwh209nn6mh06rdr4kk1",
                      "unit_price": {
                        "amount": "1100",
                        "currency_code": "USD"
                      },
                      "description": "Subscription month 2",
                      "trial_period": {
                        "interval": "week",
                        "frequency": 1
                      },
                      "billing_cycle": {
                        "interval": "month",
                        "frequency": 2
                      },
                      "unit_price_overrides": []
                    },
                    "price_id": "pri_01ha840zrqpwegbbvxafhtbqtk",
                    "quantity": 1,
                    "proration": null
                  }
                ],
                "origin": "subscription_recurring",
                "status": "$paddleTransactionStatus",
                "details": {
                  "totals": {
                    "fee": null,
                    "tax": "176",
                    "total": "1100",
                    "credit": "0",
                    "balance": "1100",
                    "discount": "0",
                    "earnings": null,
                    "subtotal": "924",
                    "grand_total": "1100",
                    "currency_code": "USD"
                  },
                  "line_items": [
                    {
                      "id": "txnitm_01ha9zew5jtwzthjspf58ps5a5",
                      "totals": {
                        "tax": "176",
                        "total": "1100",
                        "discount": "0",
                        "subtotal": "924"
                      },
                      "product": {
                        "id": "pro_01ha32dwh209nn6mh06rdr4kk1",
                        "name": "Monthly AI Images",
                        "status": "active",
                        "image_url": null,
                        "description": "Monthly AI Images",
                        "tax_category": "standard"
                      },
                      "price_id": "pri_01ha840zrqpwegbbvxafhtbqtk",
                      "quantity": 1,
                      "tax_rate": "0.19",
                      "unit_totals": {
                        "tax": "176",
                        "total": "1100",
                        "discount": "0",
                        "subtotal": "924"
                      }
                    }
                  ],
                  "payout_totals": null,
                  "tax_rates_used": [
                    {
                      "totals": {
                        "tax": "176",
                        "total": "1100",
                        "discount": "0",
                        "subtotal": "924"
                      },
                      "tax_rate": "0.19"
                    }
                  ]
                },
                "checkout": {
                  "url": "https://localhost:8080/checkout?_ptxn=txn_01ha9zew3q65atp1waqccwnzxt"
                },
                "payments": [],
                "billed_at": "2023-09-14T13:53:01.559792593Z",
                "address_id": "add_01ha9x6hdcgekqapsmr9b8x1wh",
                "created_at": "2023-09-14T13:53:01.635440669Z",
                "invoice_id": null,
                "updated_at": "2023-09-14T13:53:01.635440669Z",
                "business_id": null,
                "custom_data": {
                  "subscriptionUuid": "$subscriptionUuid"
                },
                "customer_id": "ctm_01ha7jzccqkg9j91khpbywhatx",
                "discount_id": null,
                "currency_code": "USD",
                "billing_period": {
                  "ends_at": "2023-11-14T13:53:00Z",
                  "starts_at": "2023-09-14T13:53:00Z"
                },
                "invoice_number": null,
                "billing_details": null,
                "collection_mode": "automatic",
                "subscription_id": "sub_01ha9x765hsx88s48fn00wkvsx"
              }
            }

JSON;

        return json_decode($json, true);
    }

    private function getPaddleSubscriptionEvent(
        string $status,
        string $type,
        string $subscriptionUuid,
    ) {
        $json = <<<JSON
        {
          "event_id": "evt_01ha9jwzvt3s73z272y1regnds",
          "event_type": "$type",
          "occurred_at": "2023-09-14T10:13:32.666955Z",
          "notification_id": "ntf_01ha9jwzz07wera978pbjms5hx",
          "data": {
            "id": "sub_01ha9jwyg99tyc05xehyn2r3bs",
            "items": [
              {
                "price": {
                  "id": "pri_01ha840zrqpwegbbvxafhtbqtk",
                  "tax_mode": "account_setting",
                  "product_id": "pro_01ha32dwh209nn6mh06rdr4kk1",
                  "unit_price": {
                    "amount": "0",
                    "currency_code": "USD"
                  },
                  "description": "Subscription month 2",
                  "trial_period": {
                    "interval": "week",
                    "frequency": 1
                  },
                  "billing_cycle": {
                    "interval": "month",
                    "frequency": 2
                  }
                },
                "status": "trialing",
                "quantity": 1,
                "recurring": true,
                "created_at": "2023-09-14T10:13:31.273Z",
                "updated_at": "2023-09-14T10:13:31.273Z",
                "trial_dates": {
                  "ends_at": "2023-09-21T10:13:31.273Z",
                  "starts_at": "2023-09-14T10:13:31.273Z"
                },
                "next_billed_at": "2023-09-21T10:13:31.273Z",
                "previously_billed_at": null
              }
            ],
            "status": "$status",
            "discount": null,
            "paused_at": null,
            "address_id": "add_01ha9jwbgtk7d8h5gpzy7ssf1j",
            "created_at": "2023-09-14T10:13:31.273Z",
            "started_at": "2023-09-14T10:13:31.273Z",
            "updated_at": "2023-09-14T10:13:31.273Z",
            "business_id": null,
            "canceled_at": null,
            "custom_data": {
              "subscriptionUuid": "$subscriptionUuid"
            },
            "customer_id": "ctm_01ha7jzccqkg9j91khpbywhatx",
            "billing_cycle": {
              "interval": "month",
              "frequency": 2
            },
            "currency_code": "USD",
            "next_billed_at": "2023-09-21T10:13:31.273Z",
            "transaction_id": "txn_01ha9jw4wbh4fz7kt4xmatxm4n",
            "billing_details": null,
            "collection_mode": "automatic",
            "first_billed_at": null,
            "scheduled_change": null,
            "current_billing_period": {
              "ends_at": "2023-09-21T10:13:31.273Z",
              "starts_at": "2023-09-14T10:13:31.273Z"
            }
          }
        }
JSON;

        return json_decode($json, true);
    }
}
