@extends('layouts.auth')
@section('content')
    <div class="col-lg-2"></div>
    <div class="col-lg-8 login">
        <!-- Title -->
        <h1>Forgot Password</h1>

        <!-- Forgot password form -->
        <form action="{{ route('password.request') }}" method="post" class="login-form">
            @csrf
            <div class="form-group">
                <label for="email">Email Address </label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address"
                    autocomplete="off" required />
                @error('email')
                    <span class="text text-danger mb-10" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                Reset Password
            </button>
        </form>
        <!-- /form -->
    </div>
    <div class="col-lg-2"></div>
@endsection
