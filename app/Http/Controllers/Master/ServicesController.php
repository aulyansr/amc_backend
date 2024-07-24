<?php

namespace App\Http\Controllers\Master;

use App\Enums\AcTypeEnum;
use App\Models\Service;

use App\Models\ServicesType;
use App\Http\Controllers\Controller;
use App\Models\RepairAttachmentItem;
use App\Http\Requests\ServiceRequest;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:services-list|services-create|services-edit|services-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:services-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:services-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:services-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $services = Service::whereNull('master_customer_id')->get();
        return view('services.index', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $data = [
            'types' => ServicesType::where('is_active', 1)->pluck('name', 'id'),
            'repairAttachmentItems' => RepairAttachmentItem::all(),
            'types_ac' => AcTypeEnum::getArray(),
        ];
        return view('services.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ServiceRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ServiceRequest $request)
    {
        $imagePath = null;
        if ($request->file('image')) {
            // Validate the form data
            $imagePath = uploadFile('image', 'public/images/services', null, false, 'service');
        }
        $service = new Service;
        $service->services_type_id = $request->input('services_type');
        $service->name = $request->input('name');
        $service->description = $request->input('description');
        $service->price = resetNumberFormat($request->input('price'));
        // $service->price_warranty = resetNumberFormat($request->input('price_warranty'));
        $service->commision = resetNumberFormat($request->input('commision'));
        $service->is_active = $request->is_active;
        $service->image = asset('storage/images/services/' . $imagePath);
        $service->max_discount = $request->max_discount;
        $service->warranty = $request->warranty;
        $service->service_time = $request->service_time;
        $service->technician_needed = $request->technician_needed;
        $service->is_show_mobile = $request->is_show_mobile;
        $service->type_ac=$request->type_ac;
        $service->pk_dari=$request->pk_dari;
        $service->pk_sampai=$request->pk_sampai;
        $service->save();
        $service->activities()->attach($request->input('activity_items'));

        return to_route('master.services.index')->with('toast_success', 'Data Service Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        // dd($service->child_services);
        return view('services.show', ['service' => $service]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {

        $data = [
            'service' => Service::findOrFail($id),
            'types' => ServicesType::where('is_active', 1)->pluck('name', 'id'),
            'repairAttachmentItems' => RepairAttachmentItem::all(),
            'types_ac' => AcTypeEnum::getArray(),
        ];

        return view('services.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ServiceRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ServiceRequest $request, $id)
    {
        $service = Service::findOrFail($id);
        $imagePath = $service->image;
        if ($request->file('image')) {
            $imagePath = uploadFile('image', 'public/images/services', $service->image, false, 'service');
        }
        $service->services_type_id = $request->input('services_type');
        $service->name = $request->input('name');
        $service->description = $request->input('description');
        $service->price = resetNumberFormat($request->input('price'));
        // $service->price_warranty = resetNumberFormat($request->input('price_warranty'));
        $service->commision = resetNumberFormat($request->input('commision'));
        $service->is_active = $request->is_active;
        $service->image = $request->file('image') ? asset('storage/images/services/' . $imagePath) : $imagePath;
        $service->max_discount = $request->max_discount;
        $service->warranty = $request->warranty;
        $service->service_time = $request->service_time;
        $service->technician_needed = $request->technician_needed;
        $service->is_show_mobile = $request->is_show_mobile;
        $service->type_ac=$request->type_ac;
        $service->pk_dari=$request->pk_dari;
        $service->is_show_mobile = $request->is_show_mobile;
        $service->pk_sampai=$request->pk_sampai;
        $service->save();
        $service->activities()->detach();
        $service->activities()->attach($request->input('activity_items'));

        return to_route('master.services.index')->with('toast_success', 'Data Service Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return to_route('master.services.index')->with('toast_success', 'Data Service Berhasil Dihapus');
    }

    public function duplicate($id){
        try{
         DB::beginTransaction();
            $service = Service::findOrFail($id);
            $clonedService = $service->replicate();
            $clonedService->id = null;
            $clonedService->push(); // Save the cloned service without firing the events

            $cloneActivities = $service->activities()->get();
            // dd($cloneActivities);
            $clonedActivities = $cloneActivities->map(function ($activity) {
                return $activity->id;
            });
            // dd($clonedActivities);
            $clonedService->activities()->attach($clonedActivities);
         DB::commit();
         return redirect()->route('master.services.edit',$clonedService->id)->with('toast_success', 'Data Service Berhasil Di duplicate');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('toast_error', $e->getMessage());
        }


    }
}
