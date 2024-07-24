<?php

namespace App\Http\Controllers;

use App\Models\MasterQr;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Indonesia;

class LandingController extends Controller
{
    public function index()
    {
        return view('public_page.index');
    }

    public function about()
    {
        return view('public_page.about');
    }

    public function services()
    {
        return view('public_page.services');
    }

    public function contact()
    {
        return view('public_page.contact');
    }

    public function detailac()
    {
        return redirect('https://acmaintenance.id/amc-pasti?utm_source=qr-code&utm_medium=brosur&utm_campaign=sales-jakarta-barat');
        return view('public_page.detailac');
    }
    public function showdetailac(MasterQr $qr)
    {
        if($qr->status==1){
            $data=[
                'qr' => $qr,
                'ac' => $qr->ac_customer,
                'history' => OrderDetail::where(['ac_customer_id'=>$qr->ac_customer->id])->orderBy('updated_at','desc')->get(),
            ];
            return view('public_page.qr_detail_ac',$data);
        }
        else{
            return redirect()->route('technician.qr_edit', $qr->url_unique)->with('toast_error','Data QR masih kosong mohon untuk di isi');
        }
    }

    public function kelebihan_kami(){
        return view('public_page.kelebihan_kami');
    }

    public function sms(){
        $data['aa'] = array();
        return view('test_view.sms',$data);
    }

    public function sms_send(Request $request){
        $phone_no = $request->phone_no;
        $pesan = $request->pesan;
        $kode_otp = rand(1111,9999);

        //echo $phone_no.' - '.$kode_otp;exit;

        //send_otp($phone_no,$pesan);
        otp_sms($phone_no,$kode_otp);
        //otp_wa($phone_no);

        return redirect('/sms')->with('success', 'Sukses kirim SMS');
    }

    public function test_map(Request $request){
        return view('test_view.maps');
    }

    public function tnc(){
        return view('public_page.tnc');
    }
    public function policy(){
        return view('public_page.policy');
    }
}
