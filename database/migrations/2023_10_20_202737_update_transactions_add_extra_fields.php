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
        Schema::table('transactions', function (Blueprint $table) {
            $table->bigInteger('total_discount')->default(0)->after('amount');
            $table->bigInteger('total_tax')->default(0)->after('total_discount');
            $table->bigInteger('total_fees')->default(0)->after('total_discount');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('total_discount');
            $table->dropColumn('total_tax');
            $table->dropColumn('total_fees');
        });
    }
};
