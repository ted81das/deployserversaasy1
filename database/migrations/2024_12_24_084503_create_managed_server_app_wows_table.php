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
        Schema::create('managed_server_app_wows', function (Blueprint $table) {
            $table->id();
$table->foreignId('managed_server_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('application_name');
            $table->string('app_hostname');
            $table->string('app_miniadmin_username');
            $table->string('app_miniadmin_email');
            $table->string('app_miniadmin_password');
            $table->string('application_user');
            $table->string('system_password');
            $table->string('db_name');
            $table->string('db_username');
            $table->string('db_password');
            $table->integer('application_user_id')->nullable();
            $table->json('system_user_info')->nullable();
            $table->string('php_version')->default('8.1');
            $table->string('webroot')->nullable();
            $table->integer('git_provider_id')->nullable();
            $table->string('clone_url')->nullable();
            $table->string('branch')->default('main');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managed_server_app_wows');
    }
};
