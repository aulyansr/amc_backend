<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Delete all existing data from the tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // Specify the tables you want to truncate
        $tables = [
            'model_has_roles',
            'role_has_permissions',
            'users',
            'permissions',
            'roles',
            // Add more tables if needed
        ];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
            PermissionSeeder::class,
            AddressSeeder::class,
            ServiceSeeder::class,
            BranchSeeder::class,
            ShiftSeeder::class,
            TechnicianLevelSeeder::class,
            TechnicianSeeder::class,
            TeamsSeeder::class,
            OrderSeeder::class,

        ]);
    }
}
