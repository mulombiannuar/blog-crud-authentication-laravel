@extends('layouts.email')
@section('content')
    <!-- /.container -->
    <div class="col-sm-12" style="margin-top:20px;">
        <h4>Dear <strong>{{ $data['name'] }},</strong></h4>
        <p>Below is your session OTP to login to {{ env('APP_NAME') }}. This OTP will expire after
            {{ env('OTP_EXPIRATION_TIME') }} minutes</p>

        <h3><strong>{{ $data['otp'] }}</strong></h3>
        <hr>
    </div>
@endsection
