<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MasterCustomer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPinController extends Controller
{
    public function index(){
        return view('public_page.auth.forgot_pin');
    }
    public function send_forgot(Request $request){
        $request->validate([
            'no_hp' => 'required|numeric',
        ]);
        $customer= MasterCustomer::where('phone', $request->no_hp)->first();
        if($customer){
            $token = Str::random(64);
            $record = DB::table('pin_resets')
            ->where('phone', $customer->phone)
            ->first();
            if($record){
                if(Carbon::parse($record->created_at)->isBefore(Carbon::now()->subMinutes(60))){
                    $token=$record->token;
                }
                else{
                    $record->delete();
                    DB::table('pin_resets')->insert([
                        'phone' => $customer->phone,
                        'token' => $token,
                        'created_at' => Carbon::now()
                    ]);
                }
            }
            else{
                DB::table('pin_resets')->insert([
                    'phone' => $customer->phone,
                    'token' => $token,
                    'created_at' => Carbon::now()
                  ]);
            }
            send_otp($request->no_hp, 'Pin reset untuk akun anda anda silahkan klik tombol dibawah untuk reset pin '.route('customer.forgot.reset_pin', $token));
            return to_route('customer.login')->with('success', 'Pin reset telah dikirim, silahkan cek pesan di nomor hp anda');
        }
        return redirect()->back()->with('error', 'No HP tidak terdaftar');
    }

    public function reset_pin($token){
        return view('public_page.auth.reset_pin', ['token' => $token]);
    }
    public function update_pin(Request $request){
        try{

            $request->validate([
                'phone' => 'required|exists:master_customers',
                'pin' => 'required|digits:6',
                'pin_confirmed' => 'required|digits:6|same:pin',
            ]);
            DB::beginTransaction();
            $updatedPin = DB::table('pin_resets')
                                ->where([
                                  'phone' => $request->phone,
                                  'token' => $request->token
                                ])
                                ->first();

            if(!$updatedPin){
                return back()->withInput()->with('error', 'Invalid token!');
            }

            $user = MasterCustomer::where('phone', $request->phone)
                        ->update(['pin' => Hash::make($request->pin)]);

            DB::table('pin_resets')->where(['phone'=> $request->phone])->delete();
            DB::commit();
            return redirect()->route('customer.login')->with('message', 'Your PIN has been changed!');
        }
        catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('toast_error','PIN Gagal Berubah');
        }
    }
}
