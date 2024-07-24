<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use App\Models\Master_skill;
use App\Http\Requests\Master_skillRequest;

class Master_skillsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:master_skills-list|master_skills-create|master_skills-edit|master_skills-delete', ['only' => ['index','show']]);
         $this->middleware('permission:master_skills-create', ['only' => ['create','store']]);
         $this->middleware('permission:master_skills-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:master_skills-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $master_skills= Master_skill::all();
        return view('master_skills.index', ['master_skills'=>$master_skills]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('master_skills.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Master_skillRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Master_skillRequest $request)
    {
        $master_skill = new Master_skill;
		$master_skill->skill_name = $request->input('skill_name');
		$master_skill->skill_desc = $request->input('skill_desc');
        $master_skill->save();

        return to_route('master.master_skills.index')->with('toast_success','Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $master_skill = Master_skill::findOrFail($id);
        return view('master_skills.show',['master_skill'=>$master_skill]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $master_skill = Master_skill::findOrFail($id);
        return view('master_skills.edit',['master_skill'=>$master_skill]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Master_skillRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Master_skillRequest $request, $id)
    {
        $master_skill = Master_skill::findOrFail($id);
		$master_skill->skill_name = $request->input('skill_name');
		$master_skill->skill_desc = $request->input('skill_desc');
        $master_skill->save();

        return to_route('master.master_skills.index')->with('toast_success','Data Berhasil Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $master_skill = Master_skill::findOrFail($id);
        $master_skill->delete();

        return to_route('master.master_skills.index')->with('toast_success','Data Berhasil dihapus');
    }
}
