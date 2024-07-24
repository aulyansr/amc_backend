<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use App\Models\Technician_level;
use App\Http\Requests\Technician_levelRequest;

class Technician_levelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */

    function __construct()
    {
         $this->middleware('permission:technician_levels-list|technician_levels-create|technician_levels-edit|technician_levels-delete', ['only' => ['index','show']]);
         $this->middleware('permission:technician_levels-create', ['only' => ['create','store']]);
         $this->middleware('permission:technician_levels-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:technician_levels-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $technician_levels= Technician_level::all();
        return view('technician_levels.index', ['technician_levels'=>$technician_levels]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('technician_levels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Technician_levelRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Technician_levelRequest $request)
    {
        $technician_level = new Technician_level;
		$technician_level->name = $request->input('name');
		$technician_level->desc = $request->input('desc');
		$technician_level->commision_service = $request->input('commision_service');
        $technician_level->save();

        return to_route('master.technician_levels.index')->with('toast_success','Berhasil Menambahkan data Level Teknisi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $technician_level = Technician_level::findOrFail($id);
        return view('technician_levels.show',['technician_level'=>$technician_level]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $technician_level = Technician_level::findOrFail($id);
        return view('technician_levels.edit',['technician_level'=>$technician_level]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Technician_levelRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Technician_levelRequest $request, $id)
    {
        $technician_level = Technician_level::findOrFail($id);
		$technician_level->name = $request->input('name');
		$technician_level->desc = $request->input('desc');
		$technician_level->commision_service = $request->input('commision_service');
        $technician_level->save();

        return to_route('master.technician_levels.index')->with('toast_success','Berhasil Mengubah data Level Teknisi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $technician_level = Technician_level::findOrFail($id);
        $technician_level->delete();

        return to_route('master.technician_levels.index')->with('toast_success','Berhasil Menghapus data Level Teknisi');
    }
}
