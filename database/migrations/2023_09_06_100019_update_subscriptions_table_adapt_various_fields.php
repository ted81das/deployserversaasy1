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
            $table->renameColumn('renew_at', 'ends_at');
            $table->timestamp('trial_ends_at')->nullable();
            $table->dropColumn('is_trial_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->renameColumn('ends_at', 'renew_at');
            $table->dropColumn('trial_ends_at');
            $table->boolean('is_trial_active')->default(false);
        });
    }
};
