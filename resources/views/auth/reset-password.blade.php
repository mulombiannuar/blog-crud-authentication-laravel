@extends('layouts.auth')
@section('content')
    <div class="col-lg-2"></div>
    <div class="col-lg-8 login">
        <h1>Reset Password</h1>

        <!-- Reset password form -->
        <form action="{{ route('password.update') }}" method="post" class="login-form">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" class="form-control" value="{{ $request->email }}">

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password"
                    autocomplete="off" required />
                @error('password')
                    <span class="text text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password Confirmation</label>
                <input type="password" id="confirmation" name="password_confirmation" class="form-control"
                    placeholder="Confirm password" required />
                @error('password_confirmation')
                    <span class="text text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                Update Password
            </button>
        </form>
        <!-- /form -->
    </div>
    <div class="col-lg-2"></div>
@endsection
