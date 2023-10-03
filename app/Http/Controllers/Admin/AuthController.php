<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\SendSMS;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOTPRequest;
use App\Jobs\SendOTPEmailJob;
use App\Services\UserService;
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
        //Update otp sms count
        $this->updateOTPSmsCount();

        //Check if user has reached maximum number os sms count and is not admin
        if (!has_role('admin')) {
            if (current_session()->sms_count > env('OTP_SMS_COUNT')) {

                //disable user
                (new UserService())->disableUser(user()->id);

                //Log out user
                $this->logOutUser();

                return redirect(route('login'))->with('danger', 'You have reached maximum number of OTP count. Please contact system administrator');
            }
        }

        $user = Auth::user();
        $session_otp =  session('session_otp');
        $subject = 'Session OTP Token - ' . now();
        $message = $this->setOTPMessage($user->name, $session_otp);

        //send session otp via sms
        SendSMS::run($user->mobile_number, $message);

        //send dispatchable job for session otp via email
        $dispatch = SendOTPEmailJob::dispatch([
            'name' => $user->name,
            'email' => $user->email,
            'message' => $message,
            'subject' => $subject,
            'otp' => $session_otp
        ]);

        //dd($dispatch);
        return back()->with('success', 'Enter OTP Code sent to ' . $this->filteredMobileNumber($user->mobile_number));
    }
}
