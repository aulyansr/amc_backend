<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
    public function run()
    {
        // Define the data for shifts
        $shifts = [
            [
                'name' => 'Shift Hari Kerja',
                'shift_from' => '08:00:00', // Example start time for weekdays
                'shift_to' => '17:00:00',   // Example end time for weekdays
                'day' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday']),
            ],
            [
                'name' => 'Shift Hari Weekend',
                'shift_from' => '09:00:00', // Example start time for weekends
                'shift_to' => '18:00:00',   // Example end time for weekends
                'day' => json_encode(['Friday', 'Saturday', 'Sunday']),
            ],
        ];

        // Insert the shifts into the database
        foreach ($shifts as $shift) {
            DB::table('shifts')->insert($shift);
        }
    }
}
