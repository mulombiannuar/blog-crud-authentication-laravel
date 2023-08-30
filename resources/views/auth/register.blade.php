@extends('layouts.auth')
@section('content')
    <div class="col-lg-2"></div>

    <!-- Signup content  -->
    <div class="col-lg-8 signup">
        <!-- Title -->
        <h1>Sign up</h1>

        <!-- Login form -->
        <form action="{{ route('register') }}" method="post" class="signup-form">
            @csrf
            <div class="form-group">
                <label for="name">Full name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}"
                    placeholder="Enter full name" autocomplete="off" autofocus required />
                @error('name')
                    <span class="text text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="emil">Email Address </label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}"
                    placeholder="Enter email address" autocomplete="off" required />
                @error('email')
                    <span class="text text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="emil">Mobile Number </label>
                <input type="number" id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}"
                    class="form-control" placeholder="Enter mobile number" autocomplete="off" required />
                @error('mobile_number')
                    <span class="text text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control"
                    placeholder="Enter password" autocomplete="off" required />
                @error('password')
                    <span class="text text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password Confirmation</label>
                <input type="password" id="confirmation" name="password_confirmation"
                    value="{{ old('password_confirmation') }}" class="form-control" placeholder="Confirm password"
                    required />
                @error('password_confirmation')
                    <span class="text text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Sign up</button>
            <p>Already have an account? <a href="{{ route('login') }}">Login Now</a></p>
        </form>
        <!-- /form -->
    </div>

    <div class="col-lg-2"></div>
@endsection
