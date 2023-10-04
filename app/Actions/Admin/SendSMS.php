<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class SendSMS
{
    use AsAction;

    public function handle(String $mobileno, String $message)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, env('CURLOPT_URL'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, env("CURLOPT_POSTFIELDS") . '&dest=' . $mobileno . '&msg=' . $message . '');
            // curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch,  CURLOPT_RETURNTRANSFER, false);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
            // curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);

            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
            $server_output = curl_exec($ch);
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                Log::error($error_msg);
                //logger()->error('You are not allowed here.');
                file_put_contents(storage_path('/logs/sms.log'), $error_msg . " \n", FILE_APPEND);
            }
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $IP = $_SERVER['HTTP_CLIENT_IP'];
            } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $IP = $_SERVER['REMOTE_ADDR'];
            }
            Log::info($server_output);
            Log::info($IP);
            curl_close($ch);
        } catch (\Throwable $e) {
            Log::error($e);
            file_put_contents(storage_path('/logs/sms.log'), $e . " \n", FILE_APPEND);
        }
    }
}
