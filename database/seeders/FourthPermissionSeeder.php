<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class FourthPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $data=[
            'service_coorporate-create','service_coorporate-edit','service_coorporate-delete'
        ];
        foreach($data as $v){
            Permission::create(['name'=>$v]);
        }
    }
}
