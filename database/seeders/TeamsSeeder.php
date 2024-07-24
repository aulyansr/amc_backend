<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsSeeder extends Seeder
{
    public function run()
    {
        // Retrieve all technicians
        $technicians = DB::table('technicians')->select('id', 'fullname')->get();

        // Retrieve all branches and shifts
        $branches = DB::table('branches')->select('id')->get();
        $shifts = DB::table('shifts')->select('id')->get();

        foreach ($technicians as $technician) {
            // Generate team name based on technician's full name
            $teamName = $technician->fullname . ' Team';

            // Get a random branch ID from the available branches
            $branchId = $branches->random()->id;

            // Get a random shift ID from the available shifts
            $shiftId = $shifts->random()->id;

            // Insert team data into the "teams" table
            $teamId = DB::table('teams')->insertGetId([
                'branch_id' => $branchId,
                'shift_id' => $shiftId,
                'nama' => $teamName,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]);

            // Determine the number of technicians to assign to the team (1 to 3)
            $numTechnicians = rand(1, 3);

            // Shuffle the technicians to assign random technicians to the team
            $shuffledTechnicians = $technicians->shuffle();

            // Take the first $numTechnicians technicians to assign to the team
            $selectedTechnicians = $shuffledTechnicians->take($numTechnicians);

            foreach ($selectedTechnicians as $selectedTechnician) {
                // Assign each selected technician to the team in the "team_technician" table
                DB::table('team_technician')->insert([
                    'team_id' => $teamId,
                    'technician_id' => $selectedTechnician->id,
                ]);
            }
        }
    }
}
