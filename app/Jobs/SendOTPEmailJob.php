<?php

namespace App\Jobs;

use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOTPEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            Mail::to($this->data['email'])->send(new SendMail([
                'name' => $this->data['name'],
                'email' =>  $this->data['email'],
                'message' =>  $this->data['message'],
                'subject' =>  $this->data['subject'],
                'otp' =>  $this->data['session_otp']
            ]));
        } catch (\Throwable $e) {
            Log::error($e);
            throw $e;
        }
    }
}
