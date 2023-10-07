@extends('layouts.main')
@section('content')
    <div class="container">
        <div style="display: none" id="errors_div" class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul id="errors_list"></ul>
        </div>
        <div style="display: none" id="success_div" class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong id="success_msg"></strong>
        </div>

        {{-- <div id="success"></div> --}}
    </div>
    <div class="col-lg-2"></div>

    <!-- Signup content  -->
    <div class="col-lg-8 signup">
        <!-- Title -->
        <h1>{{ $title }}</h1>

        <!-- Add form -->
        <form id="student_form" enctype="multipart/form-data" method="post" class="signup-form">
            @csrf
            <input type="hidden" id="password" value="{{ $password }}">
            <input type="hidden" id="password_confirmation" value="{{ $password }}">
            <div class="form-group">
                <label for="name">Full name</label>
                <input type="text" id="name" class="form-control" placeholder="Enter full name" autocomplete="off"
                    autofocus required />
            </div>

            <div class="form-group">
                <label for="emil">Email Address </label>
                <input type="email" id="email" class="form-control" placeholder="Enter email address"
                    autocomplete="off" required />
            </div>

            <div class="form-group">
                <label for="emil">Mobile Number </label>
                <input type="number" id="mobile_number" minlength="10" maxlength="10" class="form-control"
                    placeholder="Enter mobile number" autocomplete="off" required />
            </div>

            <div class="form-group">
                <label for="name">Course</label>
                <input type="text" id="course" class="form-control" placeholder="Enter course name" autocomplete="off"
                    required />
            </div>

            <button type="button" id="add_student" class="btn btn-primary">Add Student</button>
        </form>
        <!-- /form -->
    </div>

    <div class="col-lg-2"></div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#add_student', function(e) {
                e.preventDefault();

                const data = {
                    'name': $('#name').val(),
                    'email': $('#email').val(),
                    'course': $('#course').val(),
                    'password': $('#password').val(),
                    'mobile_number': $('#mobile_number').val(),
                    'password_confirmation': $('#password_confirmation').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: "{{ route('admin.students.store') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.status == 400) {
                            $('#success_div').hide();
                            $('#errors_div').show();
                            $.each(response.errors, function(key, err) {
                                $('#errors_list').append('<li >' + err + '</li>');
                            });
                        } else {
                            $('#success_div').show();
                            $('#errors_div').hide();
                            $("#success_msg").text(response.message);
                            $("#student_form").find("input").val("");
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
        });
    </script>
@endpush
