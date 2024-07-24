<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\RepairAttachmentItem;
use App\Models\Service;

class ServiceActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = Service::all();
        $repairAttachmentItems = RepairAttachmentItem::all();

        foreach ($services as $service) {
            $service->activities()->attach($repairAttachmentItems);
        }
    }
}
