<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterAcRequest;
use App\Models\MasterAc;
use App\Models\MasterCustomer;
use Illuminate\Http\Request;

class MasterAcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
         $this->middleware('permission:masterac-list|masterac-create|masterac-edit|masterac-delete', ['only' => ['index','show']]);
         $this->middleware('permission:masterac-create', ['only' => ['create','store']]);
         $this->middleware('permission:masterac-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:masterac-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data=array(
            'masterac' => MasterAc::all(),
        );
        return view('masterac.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data= array(
            'masterac' => new MasterAc,
        );
        return view('masterac.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MasterAcRequest $request)
    {
        $insert = array(
            'brand' => $request->brand,
            'ac_name' => $request->ac_name,
            'model' => $request->model,
            'pk' => $request->pk,
            'is_inverter' => $request->is_inverter,
            'freon_type'=> $request->freon_type,
        );
        MasterAc::create($insert);
        return redirect()->route('master.masterac.index')->with('toast_success','Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterAc $masterac)
    {
        return view('masterac.show',$masterac);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterAc $masterac)
    {
        $data=array(
            'masterac' => $masterac,
        );

        return view('masterac.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MasterAcRequest $request, MasterAc $masterac)
    {
        $update = array(
            'brand' => $request->brand,
            'ac_name' => $request->ac_name,
            'model' => $request->model,
            'pk' => $request->pk,
            'is_inverter' => $request->is_inverter,
            'freon_type'=> $request->freon_type,
        );
        $masterac->update($update);
        return redirect()->route('master.masterac.index')->with('toast_success','Data Berhasil Diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterAc $masterac)
    {
        $masterac->delete();
        return redirect()->route('master.masterac.index')->with('toast_success','Data Berhasil Dihapus');
    }
}
