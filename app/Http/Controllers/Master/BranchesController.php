<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use App\Models\Branch;
use App\Http\Requests\BranchRequest;

class BranchesController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:branches-list|branches-create|branches-edit|branches-delete', ['only' => ['index','show']]);
         $this->middleware('permission:branches-create', ['only' => ['create','store']]);
         $this->middleware('permission:branches-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:branches-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $branches= Branch::all();
        return view('branches.index', ['branches'=>$branches]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BranchRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BranchRequest $request)
    {
        $branch = new Branch;
		$branch->name = $request->input('name');
		$branch->phone = $request->input('phone');
		$branch->address = $request->input('address');
		$branch->latitude = $request->input('latitude');
		$branch->longitude = $request->input('longitude');
		$branch->max = $request->input('max');
        $branch->save();

        return to_route('master.branch.index')->with('toast_success','Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $branch = Branch::findOrFail($id);
        return view('branches.show',['branch'=>$branch]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        return view('branches.edit',['branch'=>$branch]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BranchRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BranchRequest $request, $id)
    {
        $branch = Branch::findOrFail($id);
		$branch->name = $request->input('name');
		$branch->phone = $request->input('phone');
		$branch->address = $request->input('address');
		$branch->latitude = $request->input('latitude');
		$branch->longitude = $request->input('longitude');
		$branch->max = $request->input('max');
        $branch->save();

        return to_route('master.branch.index')->with('toast_success','Data Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return to_route('master.branch.index')->with('toast_success','Data Berhasil Di Hapus');
    }
}
