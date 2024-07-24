<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Branch 1: PIK
        DB::table('branches')->insert([
            'name' => 'PIK',
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'latitude' => $faker->latitude,
            'longitude' => $faker->longitude,
            'max' => $faker->randomFloat(2, 1, 100),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Branch 2: Grogol
        DB::table('branches')->insert([
            'name' => 'Grogol',
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'latitude' => $faker->latitude,
            'longitude' => $faker->longitude,
            'max' => $faker->randomFloat(2, 1, 100),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Branch 3: Kemang
        DB::table('branches')->insert([
            'name' => 'Kemang',
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'latitude' => $faker->latitude,
            'longitude' => $faker->longitude,
            'max' => $faker->randomFloat(2, 1, 100),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
