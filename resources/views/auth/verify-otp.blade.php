@extends('layouts.auth')
@section('content')
    <div class="col-lg-2"></div>
    <div class="col-lg-8 login">
        <!-- Title -->
        <h1>Verify OTP</h1>

        <!-- Forgot password form -->
        <form action="{{ route('auth.otp.verify') }}" method="post" id="otpForm" class="login-form">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="otp">Enter OTP sent to <strong>{{ $mobile_number }}</strong> </label>
                <input type="number" id="otp" name="otp" class="form-control"
                    placeholder="Enter OTP sent to your phone/email" autocomplete="off" required />
                @error('otp')
                    <span class="text text-danger mb-10" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button disabled type="submit" id="submit" class="btn btn-primary">
                Verify OTP
            </button>
            <p>Didn't receive OTP? <a href="{{ route('password.request') }}">Resend Now</a></p>
        </form>
        <!-- /form -->
    </div>
    <div class="col-lg-2"></div>
@endsection

@push('scripts')
    <script>
        $('#otpForm').on("keyup", action);

        function action() {
            if ($('#otp').val().length == 6) {
                $('#submit').prop("disabled", false);
            } else {
                $('#submit').prop("disabled", true);
            }
        }
    </script>
@endpush
