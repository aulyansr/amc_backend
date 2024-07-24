<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $orders = DB::table('orders')->get();
        $i=1;
        foreach ($orders as $order) {
            $orderCode = "TR-AMC-".str_pad($i, 4, '0', STR_PAD_LEFT);// Generate or retrieve the order code for each record
            DB::table('orders')->where('id', $order->id)->update(['order_code' => $orderCode]);
            $i++;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
