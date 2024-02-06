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
        Schema::table('oauth_login_providers', function (Blueprint $table): void {
            $table->dropColumn('client_secret');
            $table->dropColumn('client_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oauth_login_providers', function (Blueprint $table): void {
            $table->string('client_secret')->nullable();
            $table->string('client_id')->nullable();
        });
    }
};
