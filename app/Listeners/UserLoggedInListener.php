<?php

namespace App\Listeners;

use App\Actions\Admin\SendSMS;
use App\Jobs\SendOTPEmailJob;
use App\Models\User;
use App\Traits\OTPToken;
use Illuminate\Auth\Events\Login;

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

        //send dispatchable job for session otp via email
        SendOTPEmailJob::dispatch([
            'name' => $event->user->name,
            'email' => $event->user->email,
            'message' => $message,
            'subject' => $subject,
            'otp' => $session_otp
        ]);
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
