<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) { // Adjust the number of rows as needed
            $created_at = Carbon::now()->subDays(rand(1, 30));

            // DB::table('master_customers')->truncate();

            DB::table('master_customers')->insert([
                'nama' => $faker->name,
                'phone' => $faker->phoneNumber,
                'OTP' => $faker->randomNumber(6),
                'email' => $faker->unique()->safeEmail,
                'access_token' => $faker->uuid,
                'refresh_token' => $faker->uuid,
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ]);
        }
    }
}
