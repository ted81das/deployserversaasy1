<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
private $defaultPublicKey = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCEzZ2087B8dNmxfXPTPbP0Gmby15wT1OmXShLJHV/yeEcpS29OBZKt1tmgO2ZteLvAEnMmaYA2rCDVWu3ux+OAWftaLb+FIY1wJsB33HKsq5A9IOTetlWNOba41R+0XI8Y7SOhvtZIbkfPjmsrPhtFZb2khkNuDutGHmj+GZP6lYjwAYmFCdthUB+wlM31QwNsmiQszX4s89LVWkXfqX52SDTBrzauuoH3ve1+A1AocZIqKPAJkYitG67HfLbxMO0vpumCySA3awUpzIP1ZZL6128kqKhx1T/C9qbex/Y0m0Iv2roNhaJI96phT9EsoXiMbUcO5hK+n4wVylgPjtSl oliveearth@yahoo.com';


    public function up()
    {
        //

 Schema::create('managed_servers', function (Blueprint $table) {
            $table->id();
            $table->uuid('server_uuid')->unique();
            
            // User input fields
            $table->string('server_name')->unique();
            $table->string('application_name');
            $table->string('plan_type')->default('vc2-1c-1gb');
            
            // Database fields (optional with defaults)
            $table->string('db_name')->nullable();
            $table->string('db_password')->nullable();
            
            // Application details
            $table->string('app_hostname');
            $table->string('app_miniadmin_username');
            $table->string('app_miniadmin_email');
            $table->string('app_miniadmin_password');
            
            // System generated fields
            $table->string('application_user')->nullable();
            $table->string('system_password')->nullable();
            $table->integer('application_user_id')->nullable();
            
            // App IDs for different applications
            $table->integer('wow_app_id')->nullable();
            $table->integer('cloud_app_id')->nullable();
            $table->integer('pavel_app_id')->nullable();
            
            // Default server configuration
            $table->string('provider')->default('vultr');
            $table->integer('cloud_server_provider_id')->default(3077);
            $table->string('version')->default('20');
            $table->string('region')->default('atl');
            $table->string('availability_zone')->default('us-east-1a');
            $table->string('size_slug')->default('vc2-1c-1gb');
            $table->boolean('ssh_key')->default(true);
            $table->text('public_key')->nullable();
            $table->string('web_server')->default('apache2');
            $table->string('database_type')->default('mysql');
            
            // Server status fields
            $table->string('ssh_status')->nullable();
            $table->string('agent_status')->nullable();
            $table->string('ip_address')->nullable();
            
            $table->timestamps();
            
            // Unique composite indexes
            $table->unique(['id', 'application_name']);
            $table->unique(['id', 'application_user']);
        });


// Set the default public_key value after column creation
       DB::table('managed_servers')->whereNull('public_key')->update([
            'public_key' => $this->defaultPublicKey
    ]);


    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
Schema::dropIfExists('managed_servers');


    }
};
