<?php

namespace App\Http\Controllers\Master;

use App\Enums\AcTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\MasterCustomer;
use App\Models\RepairAttachmentItem;
use App\Models\Service;
use App\Models\ServicesType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceCorporateController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:service_coorporate-list|service_coorporate-create|service_coorporate-edit|service_coorporate-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:service_coorporate-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:service_coorporate-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:service_coorporate-delete', ['only' => ['destroy']]);
    }
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
    public function create($master_customer_id)
    {
        $data = [
            'types' => ServicesType::where('is_active', 1)->pluck('name', 'id'),
            'master_customer_id' => $master_customer_id,
            'customer' => MasterCustomer::find($master_customer_id),
            'repairAttachmentItems' => RepairAttachmentItem::all(),
            'types_ac' => AcTypeEnum::getArray(),
        ];

        return view('service_coorporate.create', $data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store($master_customer_id, ServiceRequest $request)
    {
        $imagePath = null;
        if ($request->file('image')) {
            // Validate the form data
            $imagePath = uploadFile('image', 'public/images/services', null, false, 'service');
        }
        $service = new Service;
        $service->master_customer_id = $master_customer_id;
        $service->services_type_id = $request->input('services_type');
        $service->name = $request->input('name');
        $service->description = $request->input('description');
        $service->price = resetNumberFormat($request->input('price'));
        $service->price_warranty = resetNumberFormat($request->input('price_warranty'));
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
        // dd($service);
        $service->save();
        $service->activities()->attach($request->input('activity_items'));
        return redirect()->route('customers.show', $master_customer_id)->with('toast_success', 'Service Customer Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::findOrFail($id);
        // dd($service->child_services);
        return view('services.show', ['service' => $service]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($master_customer_id, Service $serviceCorporate)
    {
        $data = [
            'types' => ServicesType::where('is_active', 1)->pluck('name', 'id'),
            'master_customer_id' => $master_customer_id,
            'service' => $serviceCorporate,
            'customer' => MasterCustomer::find($master_customer_id),
            'repairAttachmentItems' => RepairAttachmentItem::all(),
            'types_ac' => AcTypeEnum::getArray(),
        ];

        return view('service_coorporate.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($master_customer_id, ServiceRequest $request, Service $serviceCorporate)
    {
        $imagePath = $serviceCorporate->image;
        if ($request->file('image')) {
            $imagePath = uploadFile('image', 'public/images/services', $serviceCorporate->image, false, 'service');
        }
        $serviceCorporate->services_type_id = $request->input('services_type');
        $serviceCorporate->name = $request->input('name');
        $serviceCorporate->description = $request->input('description');
        $serviceCorporate->price = resetNumberFormat($request->input('price'));
        $serviceCorporate->price_warranty = resetNumberFormat($request->input('price_warranty'));
        $serviceCorporate->commision = resetNumberFormat($request->input('commision'));
        $serviceCorporate->is_active = $request->is_active;
        $serviceCorporate->image = $request->file('image') ? asset('storage/images/services/' . $imagePath) : $imagePath;
        $serviceCorporate->max_discount = $request->max_discount;
        $serviceCorporate->warranty = $request->warranty;
        $serviceCorporate->service_time = $request->service_time;
        $serviceCorporate->technician_needed = $request->technician_needed;
        $serviceCorporate->is_show_mobile = $request->is_show_mobile;
        $serviceCorporate->type_ac=$request->type_ac;
        $serviceCorporate->pk_dari=$request->pk_dari;
        $serviceCorporate->is_show_mobile = $request->is_show_mobile;
        $serviceCorporate->pk_sampai=$request->pk_sampai;
        $serviceCorporate->save();
        $serviceCorporate->activities()->detach();
        $serviceCorporate->activities()->attach($request->input('activity_items'));
        return redirect()->route('customers.show', $master_customer_id)->with('toast_success', 'Service Customer Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($master_customer_id, Service $serviceCorporate)
    {
        //
        $serviceCorporate->delete();
        return redirect()->back()->with('toast_success', 'Data berhasil di hapus');
    }

    public function duplicate($customer_id,$id){
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
         return redirect()->route('customers.service_corporate.edit',[$customer_id,$clonedService->id])->with('toast_success', 'Data Service Berhasil Di duplicate');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('toast_error', $e->getMessage());
        }


    }
}
