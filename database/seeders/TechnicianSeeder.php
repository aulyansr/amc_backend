<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as FakerFactory;

class TechnicianSeeder extends Seeder
{
    public function run()
    {
        // Define the number of technicians to create
        $numTechnicians = 10; // You can adjust the number as needed

        // Retrieve technician level IDs (assuming you have levels created in the technician_levels table)
        $technicianLevelIds = DB::table('technician_levels')->pluck('id')->toArray();

        $faker = FakerFactory::create();
        $usedEmails = [];

        foreach (range(1, $numTechnicians) as $index) {
            // Generate a random prefix among the specified options
            $prefixes = ['62812', '62857', '62813', '62899'];
            $randomPrefix = $faker->randomElement($prefixes);

            // Generate a random 10-digit number
            $randomNumber = $faker->numberBetween(1000000000, 9999999999);

            // Combine the prefix and number to create the phone number (14 characters)
            $phoneNumber = $randomPrefix . str_pad($randomNumber, 4, '0', STR_PAD_LEFT);

            // Generate a random full name
            $fullName = $faker->firstName . ' ' . $faker->lastName;

            // Create the email address using the full name
            $email = str_replace(' ', '', $fullName) . '@amc.id';

            // Ensure email uniqueness
            while (in_array($email, $usedEmails)) {
                $index++; // Increase index if the email is not unique
                $email = str_replace(' ', '', $fullName) . '@amc.id';
            }
            $usedEmails[] = $email;

            $randomNik = mt_rand(10000000000000, 99999999999999); // Generate a random 14-digit number

            DB::table('technicians')->insert([
                'technician_level_id' => rand(1, count($technicianLevelIds)),
                'nik' => $randomNik,
                'fullname' => $fullName,
                'nickname' => null,
                'no_hp' => $phoneNumber, // Set the generated phone number
                'gender' => 'Male',
                'birthdate' => null,
                'avatar' => null,
                'is_active' => 1,
                'join_date' => now(),
                'leave_date' => null,
                'email' => $email, // Set the generated email
                'password' => Hash::make('password'), // Hash the password "password"
                'leave_reason' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'remember_token' => null,
            ]);
        }
    }
}
