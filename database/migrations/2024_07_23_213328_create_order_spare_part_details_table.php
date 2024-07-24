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
        Schema::create('order_spare_part_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spare_part_id');
            $table->foreignId('order_id');
            $table->double('quantity')->nullable()->default(0);
            $table->double('base_price')->nullable()->default(0);
            $table->double('discount')->nullable()->default(0);
            $table->double('total_price')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_spare_part_details');
    }
};
