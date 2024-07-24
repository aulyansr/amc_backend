<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $data=[
            'user-list','user-create','user-edit','user-delete',
            'role-list','role-create','role-edit','role-delete',
            'permission-list','permission-create','permission-edit','permission-delete',
            'mastercustomer-list','mastercustomer-create','mastercustomer-edit','mastercustomer-delete',
            'masterac-list','masterac-create','masterac-edit','masterac-delete',
            'masterqr-list','masterqr-create','masterqr-edit','masterqr-delete','masterqr-generatepdf',
            'master_skills-list','master_skills-create','master_skills-edit','master_skills-delete',
            'branches-list','branches-create','branches-edit','branches-delete',
            'technician_levels-list','technician_levels-create','technician_levels-edit','technician_levels-delete',
            'services-list','services-create','services-edit','services-delete',
            'shifts-list','shifts-create','shifts-edit','shifts-delete',
            'teams-list','teams-create','teams-edit','teams-delete',
            'technicians-list','technicians-create','technicians-edit','technicians-delete',
            'orders-list','orders-create','orders-edit','orders-delete','orders-payment','orders-assignteam',
        ];
        foreach($data as $v){
            Permission::create(['name'=>$v]);
        }
    }
}
