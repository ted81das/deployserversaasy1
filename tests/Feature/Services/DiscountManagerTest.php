<?php

namespace Feature\Services;

use App\Models\Discount;
use App\Models\Plan;
use App\Models\User;
use App\Services\DiscountManager;
use Illuminate\Support\Str;
use Tests\Feature\FeatureTest;

class DiscountManagerTest extends FeatureTest
{
    public function test_is_code_redeemable()
    {
        // add a discount
        $discount = Discount::create([
            'name' => 'test',
            'description' => 'test',
            'type' => 'percentage',
            'amount' => 10,
            'is_active' => true,
            'valid_until' => null,
            'action_type' => null,
            'max_redemptions' => -1,
            'max_redemptions_per_user' => -1,
            'is_recurring' => false,
            'redemptions' => 0,
        ]);

        $code = Str::random(10);
        $discountCode = $discount->codes()->create([
            'code' => $code,
        ]);

        $user = User::factory()->create();

        // find plan from database
        $plan = Plan::take(1)->first();

        $discountManager = app()->make(DiscountManager::class);

        $this->assertTrue($discountManager->isCodeRedeemable($code, $user, $plan));
    }

    public function test_is_code_not_redeemable_because_of_valid_until()
    {
        // add a discount
        $discount = Discount::create([
            'name' => 'test',
            'description' => 'test',
            'type' => 'percentage',
            'amount' => 10,
            'is_active' => true,
            'valid_until' => now()->subDay(),
            'action_type' => null,
            'max_redemptions' => -1,
            'max_redemptions_per_user' => -1,
            'is_recurring' => false,
            'redemptions' => 0,
        ]);

        $code = Str::random(10);
        $discountCode = $discount->codes()->create([
            'code' => $code,
        ]);

        $user = User::factory()->create();

        // find plan from database
        $plan = Plan::take(1)->first();

        $discountManager = app()->make(DiscountManager::class);

        $this->assertFalse($discountManager->isCodeRedeemable($code, $user, $plan));
    }

    public function test_is_code_not_redeemable_because_of_max_redemptions()
    {
        // add a discount
        $discount = Discount::create([
            'name' => 'test',
            'description' => 'test',
            'type' => 'percentage',
            'amount' => 10,
            'is_active' => true,
            'valid_until' => null,
            'action_type' => null,
            'max_redemptions' => 1,
            'max_redemptions_per_user' => -1,
            'is_recurring' => false,
            'redemptions' => 2,
        ]);

        $code = Str::random(10);
        $discountCode = $discount->codes()->create([
            'code' => $code,
        ]);

        $user = User::factory()->create();

        // find plan from database
        $plan = Plan::take(1)->first();

        $discountManager = app()->make(DiscountManager::class);

        $this->assertFalse($discountManager->isCodeRedeemable($code, $user, $plan));
    }

    public function test_is_code_not_redeemable_because_of_is_active()
    {
        // add a discount
        $discount = Discount::create([
            'name' => 'test',
            'description' => 'test',
            'type' => 'percentage',
            'amount' => 10,
            'is_active' => false,
            'valid_until' => null,
            'action_type' => null,
            'max_redemptions' => -1,
            'max_redemptions_per_user' => -1,
            'is_recurring' => false,
            'redemptions' => 0,
        ]);

        $code = Str::random(10);
        $discountCode = $discount->codes()->create([
            'code' => $code,
        ]);

        $user = User::factory()->create();

        // find plan from database
        $plan = Plan::take(1)->first();

        $discountManager = app()->make(DiscountManager::class);

        $this->assertFalse($discountManager->isCodeRedeemable($code, $user, $plan));
    }

    public function test_is_code_not_redeemable_because_of_max_redemptions_per_user()
    {
        // add a discount
        $discount = Discount::create([
            'name' => 'test',
            'description' => 'test',
            'type' => 'percentage',
            'amount' => 10,
            'is_active' => true,
            'valid_until' => null,
            'action_type' => null,
            'max_redemptions' => -1,
            'max_redemptions_per_user' => 1,
            'is_recurring' => false,
            'redemptions' => 0,
        ]);

        $code = Str::random(10);
        $discountCode = $discount->codes()->create([
            'code' => $code,
        ]);

        $user = User::factory()->create();

        // find plan from database
        $plan = Plan::take(1)->first();

        $discountManager = app()->make(DiscountManager::class);

        $discountCode->redemptions()->create([
            'user_id' => $user->id,
        ]);

        $this->assertFalse($discountManager->isCodeRedeemable($code, $user, $plan));
    }

    public function test_is_code_not_redeemable_because_of_plan()
    {
        // add a discount
        $discount = Discount::create([
            'name' => 'test',
            'description' => 'test',
            'type' => 'percentage',
            'amount' => 10,
            'is_active' => true,
            'valid_until' => null,
            'action_type' => null,
            'max_redemptions' => -1,
            'max_redemptions_per_user' => -1,
            'is_recurring' => false,
            'redemptions' => 0,
        ]);

        $code = Str::random(10);
        $discountCode = $discount->codes()->create([
            'code' => $code,
        ]);

        $user = User::factory()->create();

        // find plan from database
        $plan = Plan::where('slug', 'basic')->first();

        $discount->plans()->attach($plan);

        $plan2 = Plan::where('slug', 'pro')->first();

        $discountManager = app()->make(DiscountManager::class);

        $this->assertFalse($discountManager->isCodeRedeemable($code, $user, $plan2));
    }



}
