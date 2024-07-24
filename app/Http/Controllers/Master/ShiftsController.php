<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use App\Models\Shift;
use App\Http\Requests\ShiftRequest;

class ShiftsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:shifts-list|shifts-create|shifts-edit|shifts-delete', ['only' => ['index','show']]);
         $this->middleware('permission:shifts-create', ['only' => ['create','store']]);
         $this->middleware('permission:shifts-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:shifts-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $shifts= Shift::all();
        return view('shifts.index', ['shifts'=>$shifts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('shifts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ShiftRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ShiftRequest $request)
    {

        $shift = new Shift;
		$shift->name = $request->input('name');
		$shift->shift_from = $request->input('shift_from');
		$shift->shift_to = $request->input('shift_to');
		$shift->day = json_encode($request->input('day'));
        $shift->save();

        return to_route('master.shifts.index')->with('toast_success','Data Shift Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $shift = Shift::findOrFail($id);
        return view('shifts.show',['shift'=>$shift]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $shift = Shift::findOrFail($id);
        return view('shifts.edit',['shift'=>$shift]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ShiftRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ShiftRequest $request, $id)
    {
        $shift = Shift::findOrFail($id);
		$shift->name = $request->input('name');
		$shift->shift_from = $request->input('shift_from');
		$shift->shift_to = $request->input('shift_to');
		$shift->day = json_encode($request->input('day'));
        $shift->save();

        return to_route('master.shifts.index')->with('toast_success','Data Shift Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);
        $shift->delete();

        return to_route('master.shifts.index')->with('toast_success','Data Shift Berhasil Dihapus');
    }
}
