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
        Schema::create('promo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('promo_name', 255)->default('');
            $table->string('promo_description', 255)->default('');
            $table->string('promo_poster', 255)->default('');
            $table->string('promo_code', 20)->default('');
            $table->bigInteger('discount_amount');
            $table->bigInteger('max_amount');
            $table->date('expired_date');
            $table->integer('max_use')->default(1);
            $table->integer('in_use')->default(0);
            $table->enum('is_joinable', ['Y','N'])->default('N');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            // $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo');
    }
};
