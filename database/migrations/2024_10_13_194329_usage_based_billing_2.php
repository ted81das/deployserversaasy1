<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('plan_price_payment_provider_data', function (Blueprint $table) {
            $table->dropIndex('plan_price_payment_provider_data_unq');

            $table->string('type')->default(\App\Constants\PaymentProviderPlanPriceType::MAIN_PRICE->value);
            $table->unique(['plan_price_id', 'payment_provider_id', 'type'], 'plan_price_payment_provider_type_data_unq');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_price_payment_provider_data', function (Blueprint $table) {
            $table->unique(['plan_price_id', 'payment_provider_id'], 'plan_price_payment_provider_data_unq');
            $table->dropColumn('type');
            $table->dropUnique('plan_price_payment_provider_type_data_unq');
        });
    }
};
