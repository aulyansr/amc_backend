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
        Schema::dropIfExists('paket_services');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('paket_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id');
            $table->foreignId('service_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};