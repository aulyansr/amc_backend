<?php

namespace App\Services;
use App\Models\Order;
class OrderService
{
    public function createNextOrder($orderId){

        $order = Order::find($orderId);
        $next_order=Order::create([

        ]);
    }

}
