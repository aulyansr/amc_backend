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
        Schema::create('ac_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_customer_id')->constrained('master_customers')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->foreignId('master_ac_id')->constrained('master_ac')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->foreignId('master_address_id')->constrained('master_addresses')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->string('room_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac_customer');
    }
};
