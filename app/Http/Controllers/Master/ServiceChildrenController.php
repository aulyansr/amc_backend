<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ChildService;
use App\Models\Service;
use Illuminate\Http\Request;
// use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class ServiceChildrenController extends Controller
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
            'service_children' => ChildService::pluck('name','id'),
        );
        return view('service_children.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Service $service)
    {
        $request->validate([
            'service_children' => 'required',

        ]);
        $service->child_services()->sync($request->service_children);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
