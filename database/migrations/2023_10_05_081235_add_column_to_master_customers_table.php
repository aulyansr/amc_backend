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
        Schema::table('master_customers', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->string('company_name',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_customers', function (Blueprint $table) {
            $table->dropColumn(['type','company_name']);
        });
    }
};