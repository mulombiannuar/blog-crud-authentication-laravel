<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\OTPToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    use OTPToken;
    //Verify OTP
    public function otpToken(): View
    {
        $pageData = [
            'title' => 'Verify OTP',
            'email' => $this->filteredEmail(Auth::user()->email),
            'mobile_number' => $this->filteredMobileNumber(Auth::user()->mobile_number)
        ];
        return view('auth.verify-otp', $pageData);
    }

    //Verify OTP
    public function verifyOTPToken(): RedirectResponse
    {
        return redirect(route('dashboard'))->with('success', 'You are logged in successfully');;
    }
}
