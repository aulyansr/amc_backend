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
        Schema::create('service_spare_part', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id');
            $table->foreignId('spare_part_id');
            $table->float('price', 10, 2);
            $table->float('price_warranty', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_spare_part');
    }
};
