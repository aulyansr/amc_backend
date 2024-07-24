<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class AddressSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get a list of master_customer_ids for relationships
        $customerIds = DB::table('master_customers')->pluck('id')->toArray();

        $addressNames = [
            'ZIPKOS Zsuite Tanjung Duren',
            'ZIPKOS KKR',
            'ZIPKOS Flamboyan',
            'Kost Lotte Gang Bates Kuningan',
            'Hugo Residence',
            'Kost Wisma Al Iman Tanah Abang',
            'Kost White House',
            'Kost Double Moon Setiabudi',
            'Kost Metropole Residence Kuningan',
            'M1 Residence Tangerang',
        ];
        $provinceCode = '31';
        $cityCode = '158';
        $districtCode = '1966';
        $villageCode = '25626';
        shuffle($addressNames); // Shuffle the array to randomize the order

        $usedAddressData = [];

        foreach ($addressNames as $addressName) {
            $customerId = $faker->randomElement($customerIds);

            // Ensure both customer_id and address_name are unique
            $uniqueData = $this->getUniqueAddressData($customerId, $addressName, $usedAddressData);

            DB::table('master_addresses')->insert([
                'master_customer_id' => $uniqueData['customer_id'],
                'province_code' => $provinceCode,
                'city_code' => $cityCode,
                'district_code' => $districtCode,
                'village_code' => $villageCode,
                'postal_code' => $faker->postcode,
                'address_detail' => $faker->address,
                'address_name' => $faker->word,
                'address_type' => $faker->word,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Track used customer_id and address_name combinations
            $usedAddressData[] = $uniqueData;
        }
    }

    private function getUniqueAddressData($customerId, $addressName, $usedAddressData)
    {
        $uniqueData = [
            'customer_id' => $customerId,
            'address_name' => $addressName,
        ];
        $counter = 1;

        while (in_array($uniqueData, $usedAddressData, true)) {
            $uniqueData = [
                'customer_id' => $customerId,
                'address_name' => $addressName . ' ' . $counter,
            ];
            $counter++;
        }

        return $uniqueData;
    }
}
