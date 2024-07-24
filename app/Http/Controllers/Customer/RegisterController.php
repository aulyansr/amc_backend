<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MasterCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Hashids\Hashids;


class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer')->except('logout');
    }

    public function register()
    {
        return view('public_page.auth.register');
    }
    public function register_agent(){
        return view('public_page.auth.agent_register');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'phone' => 'required|string|numeric|min:10',
            // additional validation rules
        ]);
        $data['errors'] = [];
        $CheckPhone = $CheckPhone = MasterCustomer::where(['phone' => $validatedData['phone'], 'is_verify' => true])
        ->orWhere(function ($query) use ($validatedData) {
            $query->where('phone', preg_replace('/^0/', '62', $validatedData['phone'], 1))
                ->where('is_verify', true);
        })
        ->first();
        if ($CheckPhone) {
            $data['errors']['phone'] = 'Nomer Hp sudah terdaftar';
        }
        if (count($data['errors']) > 0) {
            # code...
            return redirect()->back()->withInput()->withErrors($data['errors']);
        } else {
            $changedPhone = $validatedData['phone'];
            if (substr($validatedData['phone'], 0, 1) === '0') {
                $changedPhone = '62' . substr($validatedData['phone'], 1);
            }
            $customer = MasterCustomer::where(['phone' => $validatedData['phone']])
                ->orWhere(['phone' => $changedPhone, 'is_verify' => true])
                ->where(['is_verify' => false])->first();
            if ($customer) {
                $customer->nama = $validatedData['nama'];
                $customer->email = $validatedData['email'];
                $customer->phone = $validatedData['phone'];
                $customer->type = 0;
                $customer->save();
            } else {
                $customer = new MasterCustomer();
                $customer->nama = $validatedData['nama'];
                $customer->email = $validatedData['email'];
                $customer->phone = $validatedData['phone'];
                $customer->type = 0;
                $customer->save();
            }
            $hashids = new Hashids('amc', 10, 'abcdefghijklmnopqrstuvwxyz1234567890');
            $hashedId = $hashids->encode($customer->id);
            $otp = strval(mt_rand(1000, 9999));
            $customer->update(['OTP' => $otp]);
            $message = "Your OTP for phone verification is: " . $otp;
            $data=otp_sms($customer->phone, $otp);
            if(!empty($data)){
                $customer->update(['OTP' => $data['otp']]);
                return redirect()->route('customer.view_check_otp', $hashedId)->with('success', 'OTP sent!');
            }
            return redirect()->back()->with('error', 'Failed to send OTP');
        }




        // perform any other actions or redirect as desired

    }
    public function view_otp(MasterCustomer $customer)
    {
        $hashids = new Hashids('amc', 10, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $hashedId = $hashids->encode($customer->id);
        return view('public_page.auth.send_otp', compact('customer', 'hashedId'));
    }
    public function otp(MasterCustomer $customer)
    {
        $otp = strval(mt_rand(1000, 9999));
        $customer->update(['OTP' => $otp]);
        $hashids = new Hashids('amc', 10, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $hashedId = $hashids->encode($customer->id);
        $message = "Your OTP for phone verification is: " . $otp;
        $data=otp_sms($customer->phone, $otp);
        if(!empty($data)){
            $customer->update(['OTP' => $data['otp']]);
            return redirect()->route('customer.view_check_otp', $hashedId)->with('success', 'OTP sent!');
        }
        return redirect()->back()->with('error', 'Failed to send OTP');
    }
    public function resend_otp(MasterCustomer $customer){
        $message = "Your OTP for phone verification is: " . $customer->OTP;
        $data=otp_sms($customer->phone, $customer->OTP);
        if(!empty($data)){
            $customer->update(['OTP' => $data['otp']]);
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'Failed to send OTP']);

    }
    public function view_check_otp(MasterCustomer $customer)
    {
        $hashids = new Hashids('amc', 10, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $hashedId = $hashids->encode($customer->id);
        return view('public_page.auth.verify_otp', compact('customer', 'hashedId'));
    }
    public function check_otp(MasterCustomer $customer, Request $request)
    {
        $otp = implode('', $request->otp);
        if ((int)$otp==(int)$customer->OTP) {
            $customer->update(['is_verify' => true]);
            $hashids = new Hashids('amc', 10, 'abcdefghijklmnopqrstuvwxyz1234567890');
            $hashedId = $hashids->encode($customer->id);
            return redirect()->route('customer.view_pin', $hashedId)->with('success', 'OTP Successfully Verified!');
        } else {
            return redirect()->back()->withErrors(['error' => 'Invalid OTP']);;
        }
    }

    public function view_pin(MasterCustomer $customer)
    {
        $hashids = new Hashids('amc', 10, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $hashedId = $hashids->encode($customer->id);
        return view('public_page.auth.create_pin', compact('customer', 'hashedId'));
    }
    public function create_pin(MasterCustomer $customer, Request $request)
    {
        $pin = implode('', $request->pin);
        $customer->update(['pin' => Hash::make($pin)]);
        Auth::guard('customer')->login($customer);
        return redirect()->route('customer.index')->with('success', 'Registration successful!');
    }
}
