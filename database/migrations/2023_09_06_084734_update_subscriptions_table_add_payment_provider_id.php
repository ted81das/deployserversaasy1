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
            $table->string('payment_provider_subscription_id')->nullable();
            $table->string('payment_provider_status')->nullable();
            $table->foreignId('payment_provider_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('payment_provider_subscription_id');
            $table->dropColumn('payment_provider_status');
            $table->dropForeign(['payment_provider_id']);
            $table->dropColumn('payment_provider_id');
        });
    }
};
