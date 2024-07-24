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
        Schema::create('master_ac', function (Blueprint $table) {
            $table->id();
            $table->string('brand')->nullable();
            $table->string('ac_name')->nullable();
            $table->string('model')->nullable();
            $table->string('pk')->nullable();
            $table->string('is_inverter')->nullable();
            $table->string('freon_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_ac');
    }
};
