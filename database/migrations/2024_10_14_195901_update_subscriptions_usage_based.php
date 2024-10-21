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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('price_type')->default(\App\Constants\PlanPriceType::FLAT_RATE->value);
            $table->json('price_tiers')->nullable();
            $table->string('price_per_unit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('price_type');
            $table->dropColumn('price_tiers');
            $table->dropColumn('price_per_unit');
        });
    }
};
