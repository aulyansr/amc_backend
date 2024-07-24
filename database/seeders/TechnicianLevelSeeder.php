<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnicianLevelSeeder extends Seeder
{
    public function run()
    {
        // Define the initial technician level data
        $levels = [
            [
                'name' => 'Supervisor',
                'desc' => 'Senior supervisor technician',
                'commision_service' => 0,
            ],
            [
                'name' => 'Senior',
                'desc' => 'Senior technician',
                'commision_service' => 0,
            ],
            [
                'name' => 'Junior',
                'desc' => 'Junior technician',
                'commision_service' => 0,
            ],
            [
                'name' => 'Support',
                'desc' => 'Technical support staff',
                'commision_service' => 0,
            ],
        ];

        // Insert the initial technician level data into the technician_levels table
        DB::table('technician_levels')->insert($levels);
    }
}
