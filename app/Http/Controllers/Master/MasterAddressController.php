<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterAddressRequest;
use App\Models\MasterAddress;
use App\Models\MasterCustomer;
use Illuminate\Http\Request;
use Indonesia;

class MasterAddressController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:masteraddress-list|masteraddress-create|masteraddress-edit|masteraddress-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:masteraddress-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:masteraddress-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:masteraddress-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index($master_customer_id)
    {
        $customer = MasterCustomer::find($master_customer_id);
        $data = array(
            'customer' => $customer,
        );
        return view('customer_address.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($master_customer_id)
    {
        $customer = MasterCustomer::find($master_customer_id);
        return view('customer_address.create', compact('master_customer_id', 'customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MasterAddressRequest $request, $master_customer_id)
    {

        $data = array(
            'master_customer_id' => $master_customer_id,
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
            'jumlah_ac' => $request->jumlah_ac ? $request->jumlah_ac : 0,
            'address_type' => $request->address_type,
            'time_open' => $request->time_open,
            'time_close' => $request->time_close,
            'next_service' => resetNumberFormat($request->next_service && !empty($request->next_service) ? $request->next_service : 0),
        );
        MasterAddress::create($data);

        // Fetch customer details using the master customer ID
        $customer = MasterCustomer::find($master_customer_id);

        // Check if the customer exists
        if ($customer) {
            // Conditional redirection based on customer type
            if ($customer->partner_id != null) {
                return redirect()->route('customers.show', $customer->partner_id)->with('toast_success', 'Alamat Customer Berhasil Ditambahkan');
            } else {
                return redirect()->route('customers.show', $customer->id)->with('toast_success', 'Alamat Customer Berhasil Ditambahkan');
            }
        }

        // Fallback redirection if customer is not found
        return redirect()->route('customers.index')->with('toast_error', 'Customer tidak ditemukan');
    }

    /**
     * Display the specified resource.
     */
    public function show($master_customer_id, MasterAddress $masterAddress)
    {
        $data = [
            'address' => $masterAddress,
            'customer' => MasterCustomer::find($master_customer_id),
            'master_customer_id' => $master_customer_id,
        ];
        return view('customer_address.edit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($master_customer_id, MasterAddress $masterAddress)
    {
        $data = [
            'address' => $masterAddress,
            'customer' => MasterCustomer::find($master_customer_id),
            'master_customer_id' => $master_customer_id,
            'kota' => Indonesia::findProvince($masterAddress->province_code, ['cities'])->cities->sortBy('name')->pluck('name', 'id'),
            'kecamatan' => Indonesia::findCity($masterAddress->city_code, ['districts'])->districts->sortBy('name')->pluck('name', 'id'),
            'kelurahan' => Indonesia::findDistrict($masterAddress->district_code, ['villages'])->villages->sortBy('name')->pluck('name', 'id'),
        ];
        return view('customer_address.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($master_customer_id, MasterAddressRequest $request, MasterAddress $masterAddress)
    {
        $data = array(
            'master_customer_id' => $master_customer_id,
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
            'jumlah_ac' => $request->jumlah_ac ? $request->jumlah_ac : 0,
            'next_service' => resetNumberFormat($request->next_service && !empty($request->next_service) ? $request->next_service : 0)
        );
        $masterAddress->update($data);
        return redirect()->route('customers.show', $master_customer_id)->with('toast_success', 'ALamat Customer Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($master_customer_id, MasterAddress $masterAddress)
    {
        $masterAddress->delete();
        return redirect()->back()->with('toast_success', 'Data berhasil di hapus');
    }
}
