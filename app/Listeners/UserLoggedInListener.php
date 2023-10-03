<?php

namespace App\Listeners;

use App\Actions\Admin\SendOTPEmail;
use App\Actions\Admin\SendSMS;
use App\Models\User;
use App\Traits\OTPToken;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;


class UserLoggedInListener
{
    use OTPToken;

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $session_otp = $this->generateOTP();
        $session_id = $this->generateSessionID();

        //Set session otp
        $this->setSessionOTP($session_id, $session_otp);

        //parameters
        $subject = 'Session OTP Token - ' . now();
        $message = $this->setOTPMessage($event->user->name, $session_otp);

        //send session otp via sms
        SendSMS::run($event->user->mobile_number, $message);

        //send session otp via email
        SendOTPEmail::run($event->user->name, $event->user->email, $message, $subject, $session_otp);
    }

    public function generateSessionID(): String
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $String = '';
        for ($i = 0; $i < 40; ++$i) {
            $String .= $characters[rand(0, $charactersLength - 1)];
        }
        return $String;
    }
}
