<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get lists of branch_ids, master_address_ids, and master_customer_ids from their respective tables
        $branchIds = DB::table('branches')->pluck('id')->toArray();
        $addressIds = DB::table('master_addresses')->pluck('id')->toArray();
        $customerIds = DB::table('master_customers')->pluck('id')->toArray();
        $teamIds = DB::table('teams')->pluck('id')->toArray();

        $reasons = [
            'AC tidak dingin',
            'AC bocor',
            'Kurang Freon',
        ];

        foreach (range(1, 10) as $index) { // Adjust the number of orders as needed
            $totalAC = $faker->numberBetween(1, 5);
            $totalBasePrice = $totalAC * 100000;
            $roundedTransportFee = round($faker->numberBetween(3000, 5000) / 500) * 500;
            $diskon = 0;
            $subTotal = $totalBasePrice + $roundedTransportFee;
            $grandTotal = $subTotal;
            $fileReceipt = $faker->imageUrl(640, 480);
            $orderStatus = $faker->numberBetween(1, 5);
            $isConfirmed = $orderStatus !== 1;

            // Insert the order into the orders table
            $orderId = DB::table('orders')->insertGetId([
        'branch_id' => $faker->randomElement($branchIds),
        'master_address_id' => $faker->randomElement($addressIds),
        'master_customer_id' => $faker->randomElement($customerIds),
        'ref_no' => $faker->unique()->text(10),
        'booked_date' => $faker->dateTimeBetween('now', '+3 days'),
        'order_status' => $orderStatus,
        'order_method' => 'order_by_admin',
        'payment_date' => $faker->dateTimeBetween('-30 days', 'now'),
        'total_ac' => $totalAC,
        'reason' => $faker->randomElement($reasons),
        'keterangan' => $faker->sentence,
        'location_range' => $faker->randomFloat(2, 1, 10),
        'total_base_price' => $totalBasePrice,
        'transport_fee' => $roundedTransportFee,
        'sub_total' => $subTotal,
        'diskon' => $diskon,
        'grand_total' => $grandTotal,
        'file_receipt' => $fileReceipt,
        'is_confirmed' => $isConfirmed,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ]);
            // Create order details
            $randomTeamId = $faker->randomElement($teamIds);

    // Create order details
    $serviceId = DB::table('services')->where('name', 'Cleaning AC')->value('id');
    $basePrice = DB::table('services')->where('name', 'Cleaning AC')->value('price');
    for ($i = 0; $i < $totalAC; $i++) {
        DB::table('order_detail')->insert([
            'order_id' => $orderId,
            'team_id' => null, // Assign a random team ID
            'service_id' => $serviceId,
            'ac_customer_id' => null,
            'order_detail_status' => 1,
            'base_price' => $basePrice,
            'discount' => 0,
            'sub_total' => $basePrice,
            'date_complete' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    // Create a record in the order_team table to associate the order with the team
    DB::table('team_order')->insert([
        'order_id' => $orderId,
        'team_id' => $randomTeamId,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ]);
        }
    }
}
