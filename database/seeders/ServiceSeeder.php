<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ServiceSeeder extends Seeder
{
    public function run()
    {
        // Define the initial service data
        $services = [
            [
                'name' => 'Cleaning AC',
                'description' => 'Cleaning air conditioner service',
                'price' => 100000,
                'commision' => 0,
                'is_active' => 1,
                'image' => null,
            ],
            [
                'name' => 'Reparasi',
                'description' => 'Air conditioner repair service',
                'price' => 400000,
                'commision' => 0,
                'is_active' => 1,
                'image' => null,
            ],
            [
                'name' => 'Bongkar Pasang',
                'description' => 'Air conditioner installation service',
                'price' => 150000,
                'commision' => 0,
                'is_active' => 1,
                'image' => null,
            ],
            [
                'name' => 'Cari AC baru',
                'description' => 'Search for a new air conditioner service',
                'price' => 10000,
                'commision' => 0,
                'is_active' => 1,
                'image' => null,
            ],
        ];

        // Insert the initial service data into the services table
        DB::table('services')->insert($services);
    }
}
