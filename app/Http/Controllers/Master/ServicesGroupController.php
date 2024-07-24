<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ServicesGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=[
            'data'=>ServicesGroup::all(),
        ];
        return view('services_group.index',$data);
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
        return view('services_group.create');
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
                'image' => 'required',
            ]);
            $imagePath=null;
            if($request->file('image')){
                // Validate the form data
                $imagePath=uploadFile('image', 'public/images/services/', null, false, 'service_group');
            }
            $service_group=new ServicesGroup;
            $service_group->name = $request->input('name');
            $service_group->description = nl2br($request->input('description'));
            $service_group->image=asset('storage/images/services/' . $imagePath);
            $service_group->is_mobile=$request->is_mobile;
            $service_group->save();
            DB::commit();
            return redirect()->route('master.services_group.index')->with('toast_success','Data Berhasil Disimpan');
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
            'service'=>ServicesGroup::find($id),
        ];
        return view('services_group.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data=[
            'data'=>ServicesGroup::find($id),
        ];
        return view('services_group.edit',$data);
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
            ]);
            $service_group=ServicesGroup::find($id);
            $imagePath=$service_group->image;
            if($request->file('image')){
                // Validate the form data
                $imagePath=uploadFile('image', 'public/images/services/', $service_group->image, false, 'service_group');
            }
            $service_group->name = $request->input('name');
            $service_group->description = nl2br($request->input('description'));
            $service_group->image=$request->file('image') ? asset('storage/images/services/' . $imagePath) : $service_group->image;
            $service_group->is_active = $request->input('is_active');
            $service_group->is_mobile=$request->is_mobile;
            $service_group->save();
            DB::commit();
            return redirect()->route('master.services_group.index')->with('toast_success','Data Berhasil Diubah');
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
        $service_group=ServicesGroup::find($id);
        $service_group->delete();
        return redirect()->route('master.services_group.index')->with('toast_success','Data Berhasil Dihapus');
    }
}
