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
                Log::info($error_msg);
                file_put_contents(storage_path('logs/sms.log'), $error_msg . " \n", FILE_USE_INCLUDE_PATH);
            }
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $IP = $_SERVER['HTTP_CLIENT_IP'];
            } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $IP = $_SERVER['REMOTE_ADDR'];
            }
            file_put_contents("log.txt", $server_output . " \n", FILE_APPEND);
            file_put_contents("log.txt", $IP . " IP 1\n", FILE_APPEND);

            Log::info($server_output);
            Log::info($IP);
            // file_put_contents("log.txt", $_SERVER['REMOTE_ADDR'] . " IP 2\n", FILE_APPEND);
            curl_close($ch);
        } catch (\Throwable $e) {
            file_put_contents("log.txt", $e . " \n", FILE_APPEND);
            Log::info($e);
        }
    }
}
