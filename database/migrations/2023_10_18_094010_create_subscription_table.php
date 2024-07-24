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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_customer_id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->bigInteger('price')->nullable();
            $table->string('status')->default('BELUM_SELESAI');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->bigInteger('price_total')->nullable();
            $table->integer('amount_worked')->default(0);
            $table->integer('amount_subscription')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
