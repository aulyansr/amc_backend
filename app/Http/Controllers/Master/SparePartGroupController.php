<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SparePartGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SparePartGroupController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:spare_part_group-list|spare_part_group-create|spare_part_group-edit|spare_part_group-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:spare_part_group-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:spare_part_group-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:spare_part_group-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=[
            'data'=>SparePartGroup::all(),
        ];
        return view('spare_part_group.index',$data);
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
        return view('spare_part_group.create');
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
            ]);
            $spare_part_group=new SparePartGroup;
            $spare_part_group->name = $request->input('name');
            $spare_part_group->save();
            DB::commit();
            return redirect()->route('master.spare_part_group.index')->with('toast_success','Data Berhasil Disimpan');
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
            'data'=>SparePartGroup::find($id),
        ];
        return view('spare_part_group.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data=[
            'data'=>SparePartGroup::find($id),
        ];
        return view('spare_part_group.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SparePartGroup $spare_part_group)
    {
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'name' => 'required',
            ]);
            $spare_part_group->name = $request->input('name');
            $spare_part_group->save();
            DB::commit();
            return redirect()->route('master.spare_part_group.index')->with('toast_success','Data Berhasil Diubah');
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
        $spare_part_group=SparePartGroup::find($id);
        $spare_part_group->delete();
        return redirect()->route('master.spare_part_group.index')->with('toast_success','Data Berhasil Dihapus');
    }
}
