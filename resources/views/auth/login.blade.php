@extends('layouts.auth')
@section('content')
    <!-- Login Page-->
    <div class="col-lg-2"></div>

    <!-- Login content  -->
    <div class="col-lg-8 login">
        <!-- Title -->
        <h1>Login</h1>

        <!-- Login form -->
        <form action="{{ route('login') }}" method="post" class="login-form">
            @csrf
            <div class="form-group">
                <label for="email">Email Address </label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address"
                    autofocus autocomplete="off" required />
                @error('email')
                    <span class="text text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

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

            <button type="submit" class="btn btn-primary">Log in</button>
            <p>Forgot password? <a href="{{ route('password.request') }}">Reset Now</a></p>
            <p>Don't have an account? <a href="{{ route('register') }}">Sign Up Now</a></p>
        </form>
        <!-- /form -->
    </div>

    <div class="col-lg-2"></div>
    </div>
    <!-- /.row -->
@endsection
