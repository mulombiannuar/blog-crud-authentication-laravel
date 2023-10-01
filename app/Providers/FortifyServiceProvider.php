<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Traits\OTPToken;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse
        {
            public function toResponse($request)
            {
                (new OTPToken())->forgetSessionOTP();
                return redirect(route('login'))->with('success', 'You are logged out successfully. Login again to proceed');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
        Fortify::loginView(function () {
            return view('auth.login', ['title' => 'Login']);
        });

        Fortify::registerView(function () {
            //return redirect(route('login'))->with('danger', 'You must be logged in to continue');
            return view('auth.register', ['title' => 'Register']);
        });

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email', ['title' => 'Email Verification']);
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password', ['title' => 'Forgot Password']);
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['title' => 'Reset Password', 'request' => $request]);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
