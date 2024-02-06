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
            $table->boolean('is_default')->default(false);
            $table->dropColumn('metadata');
            $table->unsignedInteger('interval_count')->nullable()->change();
            $table->unsignedBigInteger('interval_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('is_default');
            $table->json('metadata')->nullable();
            $table->unsignedInteger('interval_count')->nullable(false)->change();
            $table->unsignedBigInteger('interval_id')->nullable(false)->change();
        });
    }
};
