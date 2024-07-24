<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ServicesGroup;
use App\Models\ServicesType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=[
            'data' => ServicesType::all(),
        ];
        return view('services_type.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data=[
            'groups' => ServicesGroup::where('is_active',1)->pluck('name','id'),
        ];
        return view('services_type.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
                'group' => 'required',
            ]);
            $service_group=new ServicesType;
            $service_group->name = $request->input('name');
            $service_group->services_group_id = $request->input('group');
            $service_group->description = nl2br($request->input('description'));
            $service_group->save();
            DB::commit();
            return redirect()->route('master.services_type.index')->with('toast_success','Data Berhasil Disimpan');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
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
            'data'=>ServicesType::find($id),
        ];
        return view('services_type.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data=[
            'data'=>ServicesType::find($id),
            'groups' => ServicesGroup::where('is_active',1)->pluck('name','id'),
        ];
        return view('services_type.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
                'group' => 'required',
            ]);
            $service_group=ServicesType::find($id);
            $service_group->name = $request->input('name');
            $service_group->services_group_id = $request->input('group');
            $service_group->description = $request->input('description');
            $service_group->is_active = $request->input('is_active');
            $service_group->save();
            DB::commit();
            return redirect()->route('master.services_type.index')->with('toast_success','Data Berhasil Diubah');
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
        $service_group=ServicesType::find($id);
        $service_group->delete();
        return redirect()->route('master.services_type.index')->with('toast_success','Data Berhasil Dihapus');
    }
}
