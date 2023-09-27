<?php

namespace App\Http\Middleware;

use App\Traits\OTPToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckOTPAuth
{
    use OTPToken;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isOTPVerified()) {
            return redirect(route('auth.otp.verify'))->with('danger', 'You must verify OTP to proceed');;
        }

        if ($this->hasOTPExpired()) {

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            return redirect(route('login'))->with('danger', 'Your OTP has expired. Login to proceed');;
        }

        return $next($request);
    }
}
