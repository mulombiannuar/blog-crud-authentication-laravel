<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//Current logged in user has specified role
function has_role(String $role_name): bool
{
    return  Auth::user()->hasRole($role_name);
}

//Get current logged in authenticated user
function user(): User
{
    return Auth::user();
}

//Change date format to specified one
function change_date_format(String $date, String $date_format): String
{
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);
}

//Get public post image path
function post_image_path(String $image_name): String
{
    return public_path('assets/images/posts/' . $image_name);
}

//Get current active session
function current_session(): Object
{
    return DB::table('otp_tokens')->where('session_id', session('session_id'))->first();
}

//Check whether OTP is verified
function is_otp_verified(): bool
{
    $session = DB::table('otp_tokens')->where('session_id', session('session_id'))->first();
    return $session->is_verified ? true : false;
}

// Format mobile number add 254 extension to it
function format_mobile_number(String $mobile_no): String
{
    return '254' . substr(trim($mobile_no), 1);
}

//Get firstname, middle name, last_name
function get_name(String $name, $type): String
{
    $name = explode(' ', $name);

    if (strtolower($type) === 'middle' && array_key_exists(1, $name))
        return is_null($name[1]) ? $name[0] : $name[1];

    if (strtolower($type) === 'last' && array_key_exists(2, $name))
        return is_null($name[2]) ? $name[0] : $name[2];

    return $name[0];
}

//Replace mobile number into asterisks
function filtered_mobile_number(String $mobile_number): String
{
    $len = strlen($mobile_number) - 1;
    for ($i = 2; $i < $len; $i++) {
        $mobile_number[$i] = '*';
    }
    return $mobile_number;
}

//Replace username part in email addresses into asterisks
function filtered_email(String $email): String
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
