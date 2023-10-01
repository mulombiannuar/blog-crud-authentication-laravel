<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Mail\SendMail;

class SendOTPEmail
{
    use AsAction;

    public function handle(String $name, String $email, String $message, String $subject, String $session_otp)
    {
        try {
            $data = [
                'name' => $name,
                'email' => $email,
                'message' => $message,
                'subject' => $subject,
                'otp' => $session_otp
            ];
            Mail::to($email)->send(new SendMail($data));
        } catch (\Throwable $e) {
            Log::info($e);
            throw $e;
        }
    }
}
