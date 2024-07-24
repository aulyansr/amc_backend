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
        Schema::create('team_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->foreignId('team_id')->constrained('teams')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_order');
    }
};
