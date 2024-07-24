<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TeknisiLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/technician/home'; // Change this to your desired technician dashboard route.

    public function __construct()
    {
        $this->middleware('guest:technician')->except('logout');
    }

    public function showLoginForm()
    {
        return view('page_teknisi.auth.login');
    }
    public function logout(Request $request)
    {
        Auth::guard('technician')->logout(); // Logout using the technician guard

        $request->session()->invalidate();

        return redirect()->route('technician.login.index'); // Redirect to the technician login page after logout
    }

    protected function guard()
    {
        return auth()->guard('technician');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }
}
