<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;

//Change date format to specified one
if (!function_exists('change_date_format')) {
    function change_date_format($date, $date_format): String
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);
    }
}

//Get public post image path
if (!function_exists('post_image_path')) {
    function post_image_path($image_name): String
    {
        return public_path('assets/images/posts/' . $image_name);
    }
}

//Get current active session
if (!function_exists('current_session')) {
    function current_session(): Object
    {
        return DB::table('otp_tokens')->where('session_id', session('session_id'))->first();
    }
}

//Check whether OTP is verified
if (!function_exists('is_otp_verified')) {
    function is_otp_verified(): bool
    {
        $session = DB::table('otp_tokens')->where('session_id', session('session_id'))->first();
        if ($session) {
            return $session->is_verified ? true : false;
        }
        return false;
    }
}

// Format mobile number add 254 extension to it
if (!function_exists('format_mobile_number')) {
    function format_mobile_number($mobile_no): String
    {
        return '254' . substr(trim($mobile_no), 1);
    }
}
