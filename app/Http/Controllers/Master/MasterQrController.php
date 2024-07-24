<?php

namespace App\Http\Controllers\Master;

use App\Enums\MasterQrStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterQrRequest;
use App\Models\MasterAc;
use App\Models\MasterCustomer;
use App\Models\MasterQr;
use App\Models\OrderDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class MasterQrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
         $this->middleware('permission:masterqr-list|masterqr-create|masterqr-edit|masterqr-delete|masterqr-generatepdf', ['only' => ['index','show']]);
         $this->middleware('permission:masterqr-create', ['only' => ['create','store']]);
         $this->middleware('permission:masterqr-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:masterqr-delete', ['only' => ['destroy']]);
         $this->middleware('permission:masterqr-generatepdf', ['only' => ['generatepdf']]);
    }
    public function index(Request $request)
    {
        $data = array(
            'status' => $request->status,
        );
        if($request->all()){
            $data['masterqr']=MasterQr::where('status',$request->status)->get();
        }
        else{
            $data['masterqr']=MasterQr::all();
        }
        return view('masterqr.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return redirect()->route('master.qrgenerate.index')->with('toast_success','Qr Berhasil Di Generate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $generates=array();
        $banyak = (int)$request->number;
        $count = MasterQr::withTrashed()->count();
        for($i=0;$i<$banyak;$i++){

            $parameter=date('dmYHis').str_replace('.', '', Uuid::uuid4());;
            $parameter= strstr($parameter, '-', true);
            $generate=array(
                'url_unique'=>$parameter,
                'status' => MasterQrStatus::AVAILABLE,
                'qr_name' => "QR-".str_pad($count+$i+1, 4, '0', STR_PAD_LEFT),
            );
            array_push($generates,$generate);
        }
        MasterQr::insert($generates);
        $data = [
            'images'=>$generates,
        ];
        $pdf = Pdf::loadView('masterqr.pdf', $data);

        // Render the PDF view and return it as a response
        return $pdf->download('exported.pdf');
        return redirect()->route('master.qrgenerate.index')->with('toast_success','Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterQr $qrgenerate)
    {
        $data=[
            'qr' => $qrgenerate,
            'ac' => $qrgenerate->ac_customer,
            'history' => OrderDetail::where(['ac_customer_id'=>$qrgenerate->ac_customer->id])->orderBy('updated_at','desc')->get(),
        ];
        return view('masterqr.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterQr $qrgenerate)
    {
        $data=array(
            'masterqr' => $qrgenerate,
            'customer' => MasterCustomer::all(),
        );

        return view('masterqr.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MasterQrRequest $request, MasterQr $qrgenerate)
    {
        DB::beginTransaction();
        try {

            $insert = array(
                'master_customer_id' => $request->customer,
                'is_inverter' => $request->is_inverter,
                'brand' => $request->brand,
                'ac_name' => $request->ac_name,
                'model' => $request->model,
                'pk' => $request->pk,
                'freon_type'=> $request->freon_type,
                'ac_category' => $request->ac_category,
                'room_name' => $request->room_name
            );
            $ac=MasterAc::create($insert);
            $update = array(
                'master_customer_id' => $request->customer,
                'master_ac_id'=> $ac->id,
                'status' => MasterQrStatus::TAKEN,
                'master_teknisi_id' => Auth::user()->id,
                'qr_name' => $request->ac_name,
            );
            $qrgenerate->update($update);
            DB::commit();
            return redirect()->route('master.qrgenerate.show',$qrgenerate->url_unique)->with('toast_success','Data Berhasil Diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error',$th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterQr $qrgenerate)
    {
        $qrgenerate->delete();
        return redirect()->route('master.qrgenerate.index')->with('toast_success','Data Berhasil Dihapus');
    }

    public function generatepdf(MasterQr $qrgenerate){
        $data = [
            'images'=>[json_decode(json_encode($qrgenerate), true)],
        ];
        $pdf = Pdf::loadView('masterqr.pdf', $data);
        // Render the PDF view and return it as a response
        return $pdf->download('exported.pdf');
    }
}
