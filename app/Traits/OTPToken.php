<?php

declare(strict_types=1);

namespace App\Traits;


use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

trait OTPToken
{
    //Check if OTP is verified
    public function isOTPVerified(): bool
    {
        //dd(session('session_id'));
        return $this->getCurrentSession()->is_verified ? true : false;
    }

    //Check if OTP has expired
    public function hasOTPExpired(): bool
    {
        $session =  DB::table('otp_tokens')->where('session_id', session('session_id'))->first();
        return $session->has_expired ? true : false;
    }

    //Verify session OTP
    public function verifySessionOTP(String $otp): String
    {
        //set expiration time of the otp
        $this->setSessionOTPExpiration();

        //check if the otp has already expired
        if ($this->hasOTPExpired()) {

            $this->forgetSessionOTP();

            Auth::logout();

            session()->invalidate();

            session()->regenerateToken();

            return 'expired';
        }

        //check if the otp is already verified
        if ($this->isOTPVerified()) {
            return 'already-verified';
        }

        if ($otp == session('session_otp')) {
            $this->forgetSessionOTP();

            //Update otp verified
            DB::table('otp_tokens')->where('session_id', session('session_id'))->update([
                'is_verified' => now(),
                'has_expired' => now(),
            ]);
            return 'verified';
        }
        return 'not-verified';
    }


    //Set Session OTP
    public function setSessionOTP(String $session_id, String $otp): void
    {
        session()->put('session_id', $session_id);
        session()->put('session_otp', $otp);
        DB::table('otp_tokens')->insert([
            'ip_address' => geoip()->getClientIP(),
            'user_id' => Auth::user()->id,
            'session_id' => $session_id,
            'session_otp' => $otp,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    //Set Session OTP Expiration
    private function setSessionOTPExpiration(): void
    {
        $expiration_time = env('OTP_EXPIRATION_TIME');
        $life_time = $this->getOTPLifeTime();
        $current_session =  $this->getCurrentSession();
        if (!$current_session->has_expired) {
            if ($life_time > $expiration_time) {
                DB::table('otp_tokens')->where('session_id', session('session_id'))->update([
                    'is_verified' => now(),
                    'has_expired' => now(),
                ]);
            }
        }
    }

    //Forget session OTP
    public function forgetSessionOTP(): void
    {
        /// Forget the current otp session variable
        session()->forget('session_otp');
        session()->forget('session_id');
        DB::table('otp_tokens')->where('session_id', session('session_id'))->update([
            'is_verified' => now(),
            'has_expired' => now(),
        ]);
    }

    //Get current session
    private function getCurrentSession()
    {
        return DB::table('otp_tokens')->where('session_id', session('session_id'))->first();
    }

    //Get OTP life time in hours
    private function getOTPLifeTime(): int
    {
        $session =  DB::table('otp_tokens')->where('session_id', session('session_id'))->first();
        $current_time = Carbon::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s"));
        $created_time = Carbon::createFromFormat('Y-m-d H:i:s', $session->created_at);
        return $created_time->diffInMinutes($current_time);
    }

    //Replace username part in email addresses into asterisks
    public function filteredEmail(String $email): String
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
    public function filteredMobileNumber(String $mobile_number): String
    {
        $len = strlen($mobile_number) - 1;
        for ($i = 2; $i < $len; $i++) {
            $mobile_number[$i] = '*';
        }
        return $mobile_number;
    }

    //set otp message sent to user
    public function setOTPMessage(String $username, String $otp): String
    {
        return $this->getGreetings($username) . 'your OTP is ' . $otp . ' and expires in ' . env('OTP_EXPIRATION_TIME') . ' mins';
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

    // Get greeting based on time
    public function getGreetings(String $username): String
    {
        date_default_timezone_set("Africa/Nairobi");
        $greetings = '';
        $time = date("H");
        if ($time < "12") {
            $greetings = "Good morning " . strtoupper($username) . ', ';
        } elseif ($time >= "12" && $time < "15") {
            $greetings = "Good afternoon " . strtoupper($username) . ', ';
        } else {
            $greetings = "Good evening " . strtoupper($username) . ', ';
        }
        return $greetings;
    }
}
