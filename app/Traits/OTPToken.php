<?php

declare(strict_types=1);

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


trait OTPToken
{
    private $session_id;
    private $user_id;

    /**
     * constructor to initialize session_id and $user_id variables
     *
     * @return void
     */
    public function __construct()
    {
        $this->session_id = session()->getId();
    }


    //Generate OTP
    public function generateOTP(): String
    {
        $generator = "1357902468";
        $result = "";
        for ($i = 1; $i <= 6; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }

    //Check if OTP is verified
    public function isOTPVerified(): bool
    {
        return $this->getCurrentSession()->is_verified ? true : false;
    }

    //Check if OTP has expired
    public function hasOTPExpired(): bool
    {
        $session =  DB::table('otp_tokens')->where('session_id', $this->session_id)->first();
        return $session->has_expired ? true : false;
    }

    //Verify session OTP
    public function verifSessionOTP(String $otp): bool
    {
        if ($otp == session('session_otp')) {
            $this->forgetSessionOTP();
            return true;
        }
        return false;
    }

    //Set Session OTP
    private function setSessionOTP(String $otp): void
    {
        session()->put('session_otp', $otp);
        DB::table('otp_tokens')->insert([
            'user_id' => Auth::user()->id,
            'session_id' => $this->session_id,
            'ip_address' => geoip()->getClientIP(),
        ]);
    }

    //Set Session OTP Expiration
    private function setSessionOTPExpiration(): void
    {
        $expiration_time = env('OTP_EXPIRATION_TIME');
        $life_time = $this->getOTPLifeTime();
        if ($life_time > $expiration_time) {
            DB::table('otp_tokens')->where('session_id', $this->session_id)->update([
                'is_verified' => now(),
                'has_expired' => now(),
            ]);
        }
    }

    //Forget session OTP
    private function forgetSessionOTP(): void
    {
        /// Forget the current otp session variable
        session()->forget('session_otp');
        DB::table('otp_tokens')->where('session_id', $this->session_id)->update([
            'is_verified' => now(),
            'has_expired' => now(),
        ]);
    }

    //Get current session
    private function getCurrentSession()
    {
        return DB::table('otp_tokens')->where('session_id', $this->session_id)->first();
    }

    //Get OTP life time in hours
    private function getOTPLifeTime(): int
    {
        $session =  DB::table('otp_tokens')->where('session_id', $this->session_id)->first();
        $current_time = Carbon::createFromFormat(now(), '2015-5-5 3:30:34');
        return $current_time->diffInHours($session->created_at);
    }

    //Replace username part in email addresses into asterisks
    public function filteredEmail($email)
    {
        $emailSplit = explode('@', $email);
        $username = $emailSplit[0];
        $domain = $emailSplit[1];
        $len = strlen($username) - 1;
        for ($i = 2; $i < $len; $i++) {
            $username[$i] = '*';
        }
        return $username . '@' . $domain;
    }

    //Replace mobile number into asterisks
    public function filteredMobileNumber($mobile_number)
    {
        $len = strlen($mobile_number) - 1;
        for ($i = 2; $i < $len; $i++) {
            $mobile_number[$i] = '*';
        }
        return $mobile_number;
    }
}
