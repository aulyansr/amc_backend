<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterAddressRequest;
use App\Models\MasterAddress;
use App\Models\MasterQr;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Indonesia;

class CustomerAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'addresses' => MasterAddress::where('master_customer_id', Auth::guard('customer')->user()->id)
                ->orderByDesc('is_main')
                ->paginate(5),
        ];
        if (Auth::guard('customer')->user()->type == 1) {

            return view('page_customer.address.list_address_corpo', $data);
        } else {
            return view('page_customer.address.list_address', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page_customer.address.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MasterAddressRequest $request)
    {
        $data = array(
            'master_customer_id' => Auth::guard('customer')->user()->id,
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
            'jumlah_ac' => $request->jumlah_ac,
            'address_type' => $request->address_type,
            'time_open'=>$request->time_open,
            'time_close'=>$request->time_close
        );
        if (Auth::guard('customer')->user()->masterAddress()->count() == 0 || empty(Auth::guard('customer')->user()->masterAddress()->where('is_main', true)->first())) {
            $data['is_main'] = 1;
        }
        MasterAddress::create($data);
        return to_route('customer.alamat.index')->with('toast_success', 'ALamat Anda Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterAddress $cdata)
    {
        $data = [
            'address' => $cdata
        ];
        return view('page_customer.address.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterAddress $cdata)
    {
        $data = [
            'address' => $cdata,
            'kota' => Indonesia::findProvince($cdata->province_code, ['cities'])->cities->sortBy('name')->pluck('name', 'id'),
            'kecamatan' => Indonesia::findCity($cdata->city_code, ['districts'])->districts->sortBy('name')->pluck('name', 'id'),
            'kelurahan' => Indonesia::findDistrict($cdata->district_code, ['villages'])->villages->sortBy('name')->pluck('name', 'id'),
        ];
        return view('page_customer.address.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MasterAddressRequest $request, MasterAddress $cdata)
    {
        $data = array(
            'master_customer_id' => Auth::guard('customer')->user()->id,
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
            'jumlah_ac' => $request->jumlah_ac,
            'address_type' => $request->address_type,
            'time_open'=>$request->time_open,
            'time_close'=>$request->time_close
        );
        $cdata->update($data);
        return to_route('customer.alamat.index')->with('toast_success', 'ALamat Anda Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterAddress $cdata)
    {
        //
    }

    public function set_main(MasterAddress $cdata)
    {
        Auth::guard('customer')->user()->masterAddress()->where('is_main', true)->update(["is_main" => false]);
        $cdata->update(["is_main" => true]);
        return to_route('customer.alamat.index')->with('toast_success', 'ALamat Utama Berhasil Diubah');
    }

    public function detail_ac(MasterQr $dataqr)
    {
        $data = [
            'qr' => $dataqr,
            'ac' => $dataqr->ac_customer,
            'history' => OrderDetail::where(['ac_customer_id' => $dataqr->ac_customer->id])->orderBy('updated_at', 'desc')->get(),
        ];
        return view('page_customer.address.detail_ac', $data);
    }
}
