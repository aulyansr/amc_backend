<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('master_qr', function (Blueprint $table) {
            $table->rename('master_ac_id', 'master_ac_customer_id');
        });
    }

    public function down()
    {
        Schema::table('master_qr', function (Blueprint $table) {
            $table->rename('master_ac_customer_id', 'master_ac_id');
        });
    }
};
