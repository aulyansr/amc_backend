<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Technician;
use App\Http\Requests\TechnicianRequest;
use App\Models\Technician_level;
use Illuminate\Support\Facades\Hash;

class TechniciansController extends Controller
{
        /**
     * Constructor for the class.
     *
     * This function sets up the middleware for the class, allowing or restricting access to certain routes based on user permissions.
     *
     * @throws Some_Exception_Class This function does not throw any exceptions.
     * @return void This function does not return a value.
     */
    function __construct()
    {
         $this->middleware('permission:technicians-list|technicians-create|technicians-edit|technicians-delete', ['only' => ['index','show']]);
         $this->middleware('permission:technicians-create', ['only' => ['create','store']]);
         $this->middleware('permission:technicians-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:technicians-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $technicians= Technician::all();
        return view('technicians.index', ['technicians'=>$technicians]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $data['technician_levels'] = Technician_level::pluck('name', 'id');
        return view('technicians.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TechnicianRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TechnicianRequest $request)
    {
        $technician = new Technician;
		$technician->technician_level_id = $request->input('technician_level_id');
		$technician->nik = $request->input('nik');
		$technician->fullname = $request->input('fullname');
		$technician->nickname = $request->input('nickname');
		$technician->no_hp = $request->input('no_hp');
		$technician->gender = $request->input('gender');
		$technician->birthdate = formatDatabaseDate($request->input('birthdate'));
		$technician->join_date = formatDatabaseDate($request->input('join_date'));
		$technician->email = $request->input('email');
		$technician->password = Hash::make($request->input('password'));
        $technician->save();

        return to_route('technicians.index')->with('toast_success','Berhasil Menambah Data Teknisi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $data['technician'] = Technician::findOrFail($id);
        $data['technician_levels'] = Technician_level::pluck('name', 'id');
        return view('technicians.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $data['technician'] = Technician::findOrFail($id);
        $data['technician_levels'] = Technician_level::pluck('name', 'id');
        return view('technicians.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TechnicianRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TechnicianRequest $request, $id)
    {
        $technician = Technician::findOrFail($id);
		$technician->technician_level_id = $request->input('technician_level_id');
		$technician->nik = $request->input('nik');
		$technician->fullname = $request->input('fullname');
		$technician->nickname = $request->input('nickname');
		$technician->no_hp = $request->input('no_hp');
		$technician->gender = $request->input('gender');
		$technician->birthdate = formatDatabaseDate($request->input('birthdate'));
		$technician->join_date = formatDatabaseDate($request->input('join_date'));
		$technician->email = $request->input('email');
		$technician->password = Hash::make($request->input('password'));
        $technician->save();

        return to_route('technicians.index')->with('toast_success','Berhasil Mengubah Data Teknisi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $technician = Technician::findOrFail($id);
        $technician->delete();

        return to_route('technicians.index')->with('toast_success','Berhasil Menghapus Data Teknisi');
    }
}
