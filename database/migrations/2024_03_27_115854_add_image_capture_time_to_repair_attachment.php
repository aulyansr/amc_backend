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
        Schema::table('repair_attachment_items', function (Blueprint $table) {
            $table->unsignedTinyInteger('image_capture_time')->nullable();
            $table->integer('row_count')->default(2)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repair_attachment_items', function (Blueprint $table) {
            $table->dropColumn('image_capture_time');
            $table->dropColumn('row_count');
        });
    }
};
