<?php

namespace App\Http\Controllers\Admin;

use Closure;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOTPRequest;
use App\Traits\OTPToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    use OTPToken;

    private $user;

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
    public function verifyOTPToken(VerifyOTPRequest $request): RedirectResponse
    {
        $response = $this->verifySessionOTP($request->otp);
        dd($response);
        if ($response === 'expired')
            return redirect(route('login'))->with('danger', 'Your OTP has expired. Login to proceed');

        if ($response === 'verified' || $response === 'already-verified')
            return redirect(route('login'))->with('success', 'You are logged in successfully');

        return redirect(route('login'))->with('danger', 'You must log in to proceed');;
    }
}
