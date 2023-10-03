<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\SendOTPEmail;
use App\Actions\Admin\SendSMS;
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
        //set expiration time of the otp
        $this->setSessionOTPExpiration();

        $response = $this->verifySessionOTP($request->otp);
        // dd($response);
        if ($response === 'expired')
            return redirect(route('login'))->with('danger', 'Your OTP has expired. Login to proceed');

        if ($response === 'verified' || $response === 'already-verified')
            return redirect(route('dashboard'))->with('success', 'You are logged in successfully');

        return back()->with('danger', 'You have entered wrong OTP code');;
    }

    //Resend OTP token
    public function sendOTPToken(): RedirectResponse
    {
        $sms_count = $this->OTPSmsCount();
        dd($sms_count);

        $user = Auth::user();
        $session_otp =  session('session_otp');
        $subject = 'Session OTP Token - ' . now();
        $message = $this->setOTPMessage($user->name, $session_otp);

        //send session otp via sms
        SendSMS::run($user->mobile_number, $message);

        //send session otp via email
        SendOTPEmail::run($user->name, $user->email, $message, $subject, $session_otp);

        return back()->with('success', 'Enter OTP Code sent to ' . $this->filteredMobileNumber($user->mobile_number));
    }
}
