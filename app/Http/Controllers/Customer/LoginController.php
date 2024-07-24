<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\MasterCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
        $this->middleware('guest:customer')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|numeric|min:10',
            'pin' => 'required|numeric|digits:6'
        ]);
        $credentials = $request->only('phone', 'pin');
        $user = MasterCustomer::where(['phone' => $credentials['phone'], 'is_verify'=>true])->first();
        if ($user && Hash::check($credentials['pin'], $user->pin)) {
            Auth::guard('customer')->login($user);
            $intendedUrl = Session::pull('url.intended');
            return redirect()->intended($intendedUrl  ?? '/customer/home');
        } else {
            return redirect()->back()->withErrors(['error' => 'Phone or PIN is incorrect']);
        }
    }

    public function showLoginForm()
    {
        return view('public_page.auth.login');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        return redirect()->route('customer.login');
    }
    protected function guard()
    {
        return Auth::guard('customer');
    }
}
