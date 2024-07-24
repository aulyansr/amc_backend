<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ChildService;
use App\Models\ServicesType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChildServiceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:child_service-list|child_service-create|child_service-edit|child_service-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:child_service-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:child_service-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:child_service-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=[
            'data'=>ChildService::all(),
        ];
        return view('child_service.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // try {
        //     DB::beginTransaction();

        //     DB::commit();
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     dd($th);
        //     //throw $th;
        //     return redirect()->back()->with('toast_error',$th->getMessage());
        // }
        $data=[
            'types' => ServicesType::where('is_active', 1)->pluck('name', 'id'),
        ];
        return view('child_service.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'service_type'=> 'required',
                'name' => 'required',
            ]);
            $child_service=new ChildService;
            $child_service->services_type_id = $request->input('service_type');
            $child_service->name = $request->input('name');
            $child_service->price = resetNumberFormat($request->input('price'));
            $child_service->warranty_price=resetNumberFormat($request->input('price'));
            $child_service->save();
            DB::commit();
            return redirect()->route('master.child_service.index')->with('toast_success','Data Berhasil Disimpan');
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            return redirect()->back()->with('toast_error',$th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data=[
            'data'=>ChildService::find($id),
        ];
        return view('child_service.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data=[
            'data'=>ChildService::find($id),
        ];
        return view('child_service.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChildService $child_service)
    {
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'service_type'=> 'required',
                'name' => 'required',
            ]);
            $child_service->services_type_id = $request->input('service_type');
            $child_service->name = $request->input('name');
            $child_service->price = resetNumberFormat($request->input('price'));
            $child_service->warranty_price=resetNumberFormat($warranty_price);
            $child_service->save();
            DB::commit();
            return redirect()->route('master.child_service.index')->with('toast_success','Data Berhasil Diubah');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            //throw $th;
            return redirect()->back()->with('toast_error',$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $child_service=ChildService::find($id);
        $child_service->delete();
        return redirect()->route('master.child_service.index')->with('toast_success','Data Berhasil Dihapus');
    }
}
