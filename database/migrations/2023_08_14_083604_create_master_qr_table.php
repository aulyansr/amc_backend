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
        Schema::create('master_qr', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_customer_id')->nullable();
            $table->foreignId('master_ac_id')->nullable();
            $table->foreignId('master_teknisi_id')->nullable();
            $table->string('qr_name')->nullable();
            $table->string('url_unique')->unique()->nullable();
            $table->string('status')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_qr');
    }
};
