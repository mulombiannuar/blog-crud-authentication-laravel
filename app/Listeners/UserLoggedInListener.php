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
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $session_otp = $this->generateOTP();
        $session_id = $this->generateSessionID();
        $this->setSessionOTP($session_id, $session_otp);

        //parameters
        $subject = 'Session OTP Token - ' . now();
        $name = $event->user->name;
        $email = $event->user->email;
        $mobile_number = $event->user->mobile_number;
        $message = $this->setOTPMessage($name, $session_otp);

        //send session otp via sms
        SendSMS::run($mobile_number, $message);

        //send session otp via email
        SendOTPEmail::run($name, $email, $message, $subject, $session_otp);
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
