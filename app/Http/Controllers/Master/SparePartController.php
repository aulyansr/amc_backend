<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SparePart;
use App\Models\SparePartGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SparePartController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:spare_part-list|spare_part-create|spare_part-edit|spare_part-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:spare_part-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:spare_part-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:spare_part-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=[
            'data'=>SparePart::all(),
        ];
        return view('spare_part.index',$data);
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
        $data=array(
            'spare_part_group'=>SparePartGroup::pluck('name','id'),
        );
        return view('spare_part.create',$data);
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
                'spare_part_group_id' => 'required',
            ]);
            $spare_part=new SparePart;
            $spare_part->name = $request->input('name');
            $spare_part->spare_part_group_id = $request->input('spare_part_group_id');
            $spare_part->save();
            DB::commit();
            return redirect()->route('master.spare_part.index')->with('toast_success','Data Berhasil Disimpan');
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
            'data'=>SparePart::find($id),
            'spare_part_group'=>SparePartGroup::pluck('name','id'),
        ];
        return view('spare_part.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data=[
            'data'=>SparePart::find($id),
            'spare_part_group'=>SparePartGroup::all(),
        ];
        return view('spare_part.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SparePart $spare_part)
    {
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'name' => 'required',
                'spare_part_group_id' => 'required',
            ]);
            $spare_part->name = $request->input('name');
            $spare_part->spare_part_group_id = $request->input('spare_part_group_id');
            $spare_part->save();
            DB::commit();
            return redirect()->route('master.spare_part.index')->with('toast_success','Data Berhasil Diubah');
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
        $spare_part=SparePart::find($id);
        $spare_part->delete();
        return redirect()->route('master.spare_part.index')->with('toast_success','Data Berhasil Dihapus');
    }
}
