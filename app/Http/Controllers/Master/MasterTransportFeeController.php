<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use App\Models\MasterTransportFee;
use Illuminate\Http\Request;

class MasterTransportFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=[
            'data' => MasterTransportFee::all(),
        ];
        return view('master_transport_fee.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master_transport_fee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'distance' => 'required',
            'distance_from' => 'required',
            'distance_to' => 'required',
            'distance_price' => 'required',
        ]);

        $insert=MasterTransportFee::create([
            'distance' => $request->distance,
            'distance_from' => $request->distance_from,
            'distance_to' => $request->distance_to,
            'distance_price' => $request->distance_price,
            'distance_price_special' => $request->distance_price_special,
        ]);
        return redirect()->route('master.transport_fee.index')->with('toast_success','Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data=[
            'data' => MasterTransportFee::find($id),
        ];
        return view('master_transport_fee.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'distance' => 'required',
            'distance_from' => 'required',
            'distance_to' => 'required',
            'distance_price' => 'required',
        ]);

        $insert=MasterTransportFee::find($id)->update([
            'distance' => $request->distance,
            'distance_from' => $request->distance_from,
            'distance_to' => $request->distance_to,
            'distance_price' => $request->distance_price,
            'distance_price_special' => $request->distance_price_special,
        ]);
        return redirect()->route('master.transport_fee.index')->with('toast_success','Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        MasterTransportFee::find($id)->delete();
        return redirect()->route('master.transport_fee.index')->with('toast_success','Data berhasil dihapus');
    }
}
