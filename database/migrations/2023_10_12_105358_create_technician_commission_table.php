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
        Schema::create('technician_commission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('technician_id')->constrained('technicians');
            $table->foreignId('order_detail_id')->nullable();
            $table->string('nama_komisi');
            $table->text('keterangan_komisi')->nullable();
            $table->string('status_komisi')->nullable();
            $table->double('nominal_komisi');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technician_commission');
    }
};
