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
        Schema::table('managed_servers', function (Blueprint $table) {
            //
 $table->string('server_instance_id')->nullable()->after('id');
            $table->string('serveravatar_id')->nullable()->after('server_instance_id');
            $table->string('vultr_instance_id')->nullable()->after('serveravatar_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('managed_servers', function (Blueprint $table) {
            //
 $table->dropColumn([
                'server_instance_id',
                'serveravatar_id',
                'vultr_instance_id'
            ]);       

 });
    }
};
