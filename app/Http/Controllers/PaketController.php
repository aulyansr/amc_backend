<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaketRequest;
use App\Models\Paket;
use App\Models\ServicesType;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=[
            'paket'=>Paket::get()
        ];
        return view('paket.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $serviceType = ServicesType::all();
        $data=[
            'serviceType' => $serviceType
        ];
        return view('paket.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaketRequest $request)
    {
        $imagePath=null;
        if($request->file('image')){
            // Validate the form data
            $imagePath=uploadFile('image', 'public/images/paket', null, false, 'paket');
            $imagePath = url('/') . '/storage/images/paket/' . $imagePath;
        }
        $insert =[
            'nama_paket'=> $request->nama_paket,
            'deskripsi_paket'=> $request->deskripsi_paket,
            'foto_paket'=> $imagePath,
            'harga_paket'=> resetNumberFormat($request->harga_paket),
            'jumlah_ac'=> resetNumberFormat($request->jumlah_ac),
            'masa_berlaku'=> $request->masa_berlaku,
            'status'=> $request->status_paket,
        ];
        $paket =Paket::create($insert);
        $paket->serviceType()->sync($request->services);
        return to_route('master.paket.index')->with('toast_success','Data Berhasil Di Simpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Paket $paket)
    {
        $serviceType = ServicesType::all();
        $data=[
            'paket'=> $paket,
            'serviceType' => $serviceType
        ];
        return view('paket.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paket $paket)
    {
        $serviceType = ServicesType::all();
        $data=[
            'paket'=> $paket,
            'serviceType' => $serviceType
        ];
        return view('paket.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaketRequest $request, Paket $paket)
    {
        $imagePath=$paket->foto_paket;
        if($request->file('image')){
            // Validate the form data
            $imagePath=uploadFile('image', 'public/images/paket', null, false, 'paket');
            $imagePath = url('/') . '/storage/images/paket/' . $imagePath;
        }
        $update =[
            'nama_paket'=> $request->nama_paket,
            'deskripsi_paket'=> $request->deskripsi_paket,
            'foto_paket'=> $imagePath,
            'harga_paket'=> $request->harga_paket,
            'jumlah_ac'=> $request->jumlah_ac,
            'masa_berlaku'=> $request->masa_berlaku,
            'status'=> $request->status_paket,
        ];
        $paket->update($update);
        $paket->serviceType()->sync($request->services);
        return to_route('master.paket.index')->with('toast_success','Data Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paket $paket)
    {
        $paket->delete();
        return to_route('master.paket.index')->with('toast_success','Data Berhasil Di Hapus');
    }
}
