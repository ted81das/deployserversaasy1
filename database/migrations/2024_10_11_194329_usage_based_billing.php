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
        Schema::table('plans', function (Blueprint $table) {
            $table->string('type')->default(\App\Constants\PlanType::FLAT_RATE->value);
            $table->foreignId('meter_id')->nullable()->constrained('plan_meters');
        });

        // create plan_usage_page_prices table
        Schema::table('plan_prices', function (Blueprint $table) {
            $table->unsignedInteger('price_per_unit')->nullable();
            $table->string('type')->default(\App\Constants\PlanPriceType::FLAT_RATE->value);
            $table->json('tiers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropForeign(['meter_id']);
            $table->dropColumn('meter_id');
        });

        Schema::table('plan_prices', function (Blueprint $table) {
            $table->dropColumn('price_per_unit');
            $table->dropColumn('type');
            $table->dropColumn('tiers');
        });
    }
};
