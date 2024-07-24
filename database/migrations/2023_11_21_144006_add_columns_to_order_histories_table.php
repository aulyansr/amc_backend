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
        Schema::table('order_histories', function (Blueprint $table) {
            //
            $table->text('reason_canceled')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable()->after('grand_total');
            $table->string('work_order',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_histories', function (Blueprint $table) {
            $table->dropColumn(['reason_canceled','created_by','work_order']);
        });
    }
};
