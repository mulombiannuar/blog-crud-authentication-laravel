<?php

namespace App\Listeners;

use App\Traits\OTPToken;
use Illuminate\Auth\Events\Logout;

class UserLoggedOutListener
{
    use OTPToken;

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        $this->forgetSession();
    }
}
