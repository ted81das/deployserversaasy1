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
        Schema::create('deployed_servers', function (Blueprint $table) {
            $table->id('server_id');
            $table->string('server_ip');
            $table->string('server_ipv6')->nullable();
            $table->string('hostname')->nullable();
            $table->unsignedBigInteger('owner_user_id');
            $table->string('owner_email');
            $table->string('root_password')->nullable();
            $table->string('operating_system')->nullable();
            $table->enum('server_status', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deployed_servers');
    }
};
