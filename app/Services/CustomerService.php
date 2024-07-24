<?php

namespace App\Services;

use App\Models\MasterAddress;
use App\Models\MasterCustomer;

class CustomerService
{
    public function insertData($request)
    {
        $insert = array(
            'nama' => $request->nama,
            'email' => $request->email,
            'phone' => $request->phone,
        );

        $customer = MasterCustomer::create($insert);

        return $customer->id;
    }

    public function insertAddress($masterCustomerId, $request)
    {
        $data = array(
            'master_customer_id' => $masterCustomerId,
            'province_code' => $request->province_code,
            'city_code' => $request->city_code,
            'district_code' => $request->district_code,
            'village_code' => $request->village_code,
            'postal_code' => $request->postal_code,
            'address_detail' => $request->address_detail,
            'landmark' => $request->landmark,
            'address_name' => $request->address_name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        );

        $address = MasterAddress::create($data);

        return $address->id;
    }
}
