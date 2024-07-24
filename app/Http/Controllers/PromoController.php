<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PromoRequest;
use App\Models\Promo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class PromoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:promo-list|promo-create|promo-edit|promo-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:promo-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:promo-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:promo-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'promos' => Promo::get()
        ];
        return view('promos.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(' promos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromoRequest $request)
    {
        try {
            DB::beginTransaction();

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request->file('image'));
            }

            $promoData = $this->preparePromoData($request, $imagePath);
            $promo = Promo::create($promoData);

            DB::commit();

            return redirect()->route('master.promos.index')
                ->with('toast_success', 'Data Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('toast_error', $e->getMessage());
        }
    }

    private function uploadImage($file)
    {
        return uploadFile('image', 'public/images/promo', null, false, 'promo');
    }

    private function preparePromoData($request, $imagePath)
    {
        $promoData = [
            'promo_name' => $request->promo_name,
            'promo_description' => $request->promo_description,
            'promo_poster' =>  asset('storage/images/promo/' . $imagePath),
            'promo_code' => $request->promo_code,
            'discount_amount' => $request->discount_amount,
            'max_amount' => $request->max_amount,
            'expired_date' => $request->expired_date,
            'max_use' => $request->max_use,
            'is_joinable' => 'Y'
        ];

        return $promoData;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $promo = Promo::findOrFail($id);
        return view('promos.show', ['promo' => $promo]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return view('promos.edit', ['promo' => $promo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PromoRequest $request, Promo $promo)
    {
        try {
            DB::beginTransaction();

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request->file('image'));
                // Delete the old image if a new one is uploaded
                $this->deleteImage($promo->promo_poster);
            }

            $promoData = $this->preparePromoData($request, $imagePath);
            $promo->update($promoData);

            DB::commit();

            return redirect()->route('master.promos.index')
                ->with('toast_success', 'Data Berhasil Diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('toast_error', $e->getMessage());
        }
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath && Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return to_route('master.promos.index')->with('toast_success', 'Data Berhasil Di Hapus');
    }
}
