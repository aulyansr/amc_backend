<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\SparePart;
use Illuminate\Http\Request;

class ServiceSparePartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Service $service)
    {
        // dd($service);
        $data=array(
            'service' => $service,
            'spare_part' => SparePart::pluck('name','id'),
        );
        return view('service_spare_part.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Service $service)
    {
        // dd($request->all());
        $request->validate([
            'spare_part_id' => 'required',
            'price' => 'required',
            'price_warranty' => 'required',

        ]);
        $service->spare_part()->syncWithoutDetaching([$request->spare_part_id => [
            'price' => $request->input('price'),
            'price_warranty' => $request->input('price_warranty')
        ]]);
        return redirect()->route('master.services.show',$service->id)->with('success', 'Service created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service, SparePart $service_spare_part)
    {
        $data=array(
            'service' => $service,
            'spare_part' => SparePart::pluck('name','id'),
            'data' => $service_spare_part
        );
        return view('service_spare_part.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service, SparePart $service_spare_part)
    {
        // dd($request->all());
        $request->validate([
            'price' => 'required',
            'price_warranty' => 'required',

        ]);
        $service->spare_part()->updateExistingPivot($service_spare_part->id, [
            'price' => $request->input('price'),
            'price_warranty' => $request->input('price_warranty')
        ]);
        return redirect()->route('master.services.show',$service->id)->with('success', 'Spare part updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service, SparePart $service_spare_part)
    {
        $service->spare_part()->detach($service_spare_part->id);
        return redirect()->route('master.services.show',$service->id)->with('success', 'Spare part deleted successfully');
    }
}
