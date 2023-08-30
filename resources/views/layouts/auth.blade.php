<!DOCTYPE html>
<html lang="en">
<!-- Head -->
@include('layouts.incls.head')

<body>
    <!-- Navigation -->
    @include('layouts.incls.navbar')
    <!-- Page Content -->
    <div class="container">
        @include('layouts.incls.alerts-auth')
        <div class="row">
            @yield('content')
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->

    <!-- Footer -->
    @include('layouts.incls.footer')

    <!-- Scripts -->
    @include('layouts.incls.scripts')
</body>

</html>
