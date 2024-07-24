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
        if (Schema::hasColumn('pakets', 'paket_service_id')) {
            Schema::table('pakets', function (Blueprint $table) {
                $table->dropColumn('paket_service_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('pakets', 'paket_service_id')) {
            Schema::table('pakets', function (Blueprint $table) {
                $table->integer('paket_service_id')->nullable();
            });
        }
    }
};
