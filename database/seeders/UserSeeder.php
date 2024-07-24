<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => '*']);
        $role = Role::create(['name' => 'Super-Admin']);
        $role->givePermissionTo('*');
        // gets all permissions via Gate::before rule; see AuthServiceProvider
        $user = \App\Models\User::factory()->create([
            'name' => 'Super-Admin ',
            'email' => 'admin@amc.id',
            'password' => Hash::make('admin@amc.id'),
        ]);
        $user->assignRole($role);
    }
}
