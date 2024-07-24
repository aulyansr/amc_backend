<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class SecondPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $data=[
            'orders-deleteassignteam','orders-completedorder','orders-invoice','orders-revision','orders-workorder',
            'mastercustomer-pin','mastercustomer-invoice_customer',
            'subscription-list','subscription-create','subscription-edit','subscription-delete',
            'paket-list','paket-create','paket-edit','paket-delete',
        ];
        foreach($data as $v){
            Permission::create(['name'=>$v]);
        }
    }
}
