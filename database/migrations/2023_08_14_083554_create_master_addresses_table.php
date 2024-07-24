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
        Schema::create('master_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_customer_id');
            $table->char('province_code', 7);
            $table->char('city_code', 4);
            $table->char('district_code', 7);
            $table->char('village_code',10);
            $table->string('postal_code',255)->nullable();
            $table->text('address_detail')->nullable();
            $table->string('landmark',255)->nullable();
            $table->string('address_name')->nullable();
            $table->string('address_type')->nullable();
            $table->string('latitude',255)->nullable();
            $table->string('longitude',255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_addresses');
    }
};
