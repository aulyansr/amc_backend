<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class ThirdPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $data=[
            'masteraddress-list','masteraddress-create','masteraddress-edit','masteraddress-delete',
        ];
        foreach($data as $v){
            Permission::create(['name'=>$v]);
        }
    }
}
