<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;

class SettingController extends Controller
{

    public function __construct(){
         $this->middleware('permission:setting-edit', ['only' => ['edit','update']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=[
            'setting'=>Setting::all(),
        ];
        return view('setting.index',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $data=[
            'settings'=>Setting::all(),
        ];
        return view('setting.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingRequest $request)
    {
        foreach($request->setting as $key => $value){
            Setting::where('key',$key)->update(['value'=>$value]);
        }
        return redirect('setting')->with('success','Setting Updated Successfully');
    }
}
