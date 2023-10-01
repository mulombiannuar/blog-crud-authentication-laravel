<!DOCTYPE html>
<html lang="en">
<!-- Head -->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ Str::ucfirst($data['subject']) }} - Simple Blog Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

</head>

<body>
    <!-- Page Content -->
    <div class="container">
        @include('layouts.incls.alerts')
        <div class="row">
            @yield('content')
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
    <!-- Footer -->
    @include('layouts.incls.footer')
</body>

</html>
