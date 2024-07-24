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
        Schema::table('ac_customers', function (Blueprint $table) {
            $table->foreignId('master_qr_id')->constrained('master_qr')
            ->onUpdate('NO ACTION')
            ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ac_customers', function (Blueprint $table) {
            $table->dropForeign(['master_qr_id']);
            $table->dropColumn('master_qr_id');
        });
    }
};
