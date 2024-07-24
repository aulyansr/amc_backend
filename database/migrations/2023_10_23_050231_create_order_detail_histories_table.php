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
        Schema::create('order_detail_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_history_id')->constrained('order_histories')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->foreignId('team_id')->nullable()->constrained('teams')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->foreignId('service_id')->constrained('services')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->foreignId('ac_customer_id')->nullable()->constrained('ac_customers')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
            $table->string('order_detail_status');
            $table->double('base_price');
            $table->double('discount')->nullable()->default(0);
            $table->double('sub_total');
            $table->datetime('date_complete')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail_histories');
    }
};
