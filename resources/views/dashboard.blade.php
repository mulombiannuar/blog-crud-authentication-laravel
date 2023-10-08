@extends('layouts.main')
@section('content')
    <!-- /.container -->
    <div class="col-sm-12" style="margin-top:20px;">
        <div class="container">
            <div style="display: none" id="errors_div" class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <ul id="errors_list"></ul>
                <strong id="error_msg"></strong>
            </div>
            <div style="display: none" id="success_div" class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong id="success_msg"></strong>
            </div>
        </div>
        <ul class="nav nav-pills">
            <li class="active">
                <a href="#users" data-toggle="tab">Manage Users</a>
            </li>
            <li><a href="#posts" data-toggle="tab">Manage Posts</a></li>
            <li><a href="#categories" data-toggle="tab">Manage Categories</a></li>
            <li><a href="#students" data-toggle="tab">Manage Students</a></li>
        </ul>

        <div class="tab-content clearfix">
            <div class="tab-pane active" id="users">
                <div class="col-lg-12">
                    <!-- Title -->
                    <h2>Manage Users</h2>
                    <hr />
                    <a href="{{ route('admin.users.create') }}">
                        <button type="button" class="text-right btn btn-sm btn-success">
                            </i> Create New User
                        </button>
                    </a>
                    @if ($users->isEmpty())
                        <div class="alert alert-danger">
                            No users were found
                        </div>
                    @else
                        <!-- Users -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Names</th>
                                    <th scope="col">Email address</th>
                                    <th scope="col">Created On</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ ucwords($user->name) }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <div class="margin btn-block">
                                                <a href="{{ route('admin.users.show', $user->id) }}">
                                                    <button type="button" class="btn btn-xs btn-success">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}">
                                                    <button type="button" class="btn btn-xs btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                                @if ($user->status == 0)
                                                    <form style="display: inline"
                                                        action="{{ route('admin.users.activate', $user->id) }}"
                                                        method="post"
                                                        onclick="return confirm('Do you really want to activate this user?')">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-xs btn-danger"><i
                                                                class="fa fa-times-circle"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form style="display: inline"
                                                        action="{{ route('admin.users.deactivate', $user->id) }}"
                                                        method="post"
                                                        onclick="return confirm('Do you really want to deactivate this user?')">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-xs btn-success"><i
                                                                class="fa fa-check-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form style="display: inline"
                                                    action="{{ route('admin.users.destroy', $user->id) }}" method="post"
                                                    onclick="return confirm('Do you really want to delete this user?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger"><i
                                                            class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <hr />
                </div>
            </div>
            <div class="tab-pane" id="posts">
                <div class="col-lg-12">
                    <!-- Title -->
                    <h2>Blog Posts</h2>
                    <hr />
                    <a href="{{ route('posts.create') }}">
                        <button type="button" class="text-right btn btn-sm btn-success">
                            </i> Create New Post
                        </button>
                    </a>
                    <!-- User Posts -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Post Title</th>
                                <th scope="col">Created On</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->created_at }}</td>
                                    <td>
                                        <div class="margin btn-block">
                                            <a href="{{ route('posts.show', $post->id) }}">
                                                <button type="button" class="btn btn-xs btn-success">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('posts.edit', $post->id) }}">
                                                <button type="button" class="btn btn-xs btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>
                                            <form style="display: inline" action="{{ route('posts.destroy', $post->id) }}"
                                                method="post"
                                                onclick="return confirm('Do you really want to delete this post?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger"><i
                                                        class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="categories">
                <div class="col-lg-12">
                    <!-- Title -->
                    <h2>Categories</h2>
                    <hr />
                    <a href="{{ route('admin.categories.create') }}">
                        <button type="button" class="text-right btn btn-sm btn-success">
                            </i> Create New Category
                        </button>
                    </a>
                    <!-- User Posts -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Created On</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->created_at }}</td>
                                    <td>
                                        <div class="margin btn-block">
                                            <a href="{{ route('admin.categories.show', $category->id) }}">
                                                <button type="button" class="btn btn-xs btn-success">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category->id) }}">
                                                <button type="button" class="btn btn-xs btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>
                                            <form style="display: inline"
                                                action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="post"
                                                onclick="return confirm('Do you really want to delete this category?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger"><i
                                                        class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="students">
                <div class="col-lg-12">
                    <!-- Title -->
                    <h2>Manage Students</h2>
                    <hr />
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                        data-target="#add_student_modal">
                        Add New Student
                    </button>
                    <!-- Students -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Names</th>
                                <th scope="col">Email address</th>
                                <th scope="col">Mobile Number</th>
                                <th scope="col">Course</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="students_data">

                        </tbody>
                    </table>
                    <hr />

                    <!-- Add student modal form -->
                    <div class="modal fade" id="add_student_modal" tabindex="-1" role="dialog"
                        aria-labelledby="add_student_modal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form id="student_add_form" enctype="multipart/form-data" method="post"
                                class="signup-form">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="modal-title">Add New Student</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="password" value="{{ $password }}">
                                        <input type="hidden" id="password_confirmation" value="{{ $password }}">

                                        <div class="form-group">
                                            <label for="name">Full name</label>
                                            <input type="text" id="name" class="form-control"
                                                placeholder="Enter full name" autocomplete="off" autofocus required />
                                            {{-- <span class="text-danger" id="file-input-error"></span> --}}
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email Address </label>
                                            <input type="email" id="email" class="form-control"
                                                placeholder="Enter email address" autocomplete="off" required />
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile_number">Mobile Number </label>
                                            <input type="number" id="mobile_number" minlength="10" maxlength="10"
                                                class="form-control" placeholder="Enter mobile number" autocomplete="off"
                                                required />
                                        </div>

                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" id="image" class="form-control" required />
                                        </div>

                                        <div class="form-group">
                                            <label for="course">Course</label>
                                            <input type="text" id="course" class="form-control"
                                                placeholder="Enter course name" autocomplete="off" required />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" id="add_student" class="btn btn-primary">Add
                                            Student</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Edit student modal form -->
                    <div class="modal fade" id="edit_student_modal" tabindex="-1" role="dialog"
                        aria-labelledby="edit_student_modal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form id="student_edit_form" enctype="multipart/form-data" method="post"
                                class="signup-form">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="modal-title">Edit Student</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="student_id">
                                        <div class="form-group">
                                            <label for="edit_name">Full name</label>
                                            <input type="text" id="edit_name" class="form-control"
                                                placeholder="Enter full name" autocomplete="off" autofocus required />
                                        </div>

                                        <div class="form-group">
                                            <label for="edit_email">Email Address </label>
                                            <input type="email" id="edit_email" class="form-control"
                                                placeholder="Enter email address" autocomplete="off" required />
                                        </div>

                                        <div class="form-group">
                                            <label for="edit_mobile_number">Mobile Number </label>
                                            <input type="number" id="edit_mobile_number" minlength="10" maxlength="10"
                                                class="form-control" placeholder="Enter mobile number" autocomplete="off"
                                                required />
                                        </div>

                                        <div class="form-group">
                                            <label for="edit_course">Course</label>
                                            <input type="text" id="edit_course" class="form-control"
                                                placeholder="Enter course name" autocomplete="off" required />
                                        </div>

                                        <div class="form-group">
                                            <label for="edit_image">Image</label>
                                            <input type="file" id="edit_image" class="form-control" />
                                        </div>
                                        {{-- <p>Image Path</p>
                                        <img id="student_image" src="" alt="" srcset=""> --}}
                                        {{-- <span id="student_image"> </span> --}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" id="update_student_button" class="btn btn-primary">Update
                                            Student</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Deelete student modal form -->
                    <div class="modal fade" id="delete_student_modal" tabindex="-1" role="dialog"
                        aria-labelledby="edit_student_modal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="modal-title">Delete Student</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="delete_student_id">
                                    <h4>Are you sure you want to delete this student?</h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="delete_student_modal_button" class="btn btn-danger">Yes
                                        Delete
                                        Student</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            fetchStudents();

            function fetchStudents() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.students.fetch') }}",
                    dataType: "json",
                    success: function(response) {
                        //console.log(response.students);
                        $("#students_data").html("");
                        $.each(response.students, function(key, student) {
                            $("#students_data").append('<tr scope="row"><td>' + student.id +
                                '</td><td>' + student.name + '</td><td>' + student.email +
                                '</td><td>' + student.mobile_number + '</td><td>' + student
                                .course +
                                '</td><td> <div class="margin btn-block"><button value="' +
                                student.id +
                                '" class="btn btn-xs btn-primary" id="edit_student_button" type="button"><i class="fa fa-edit"></i></button>&nbsp; <button value="' +
                                student.id +
                                '" class="btn btn-xs btn-danger" id="delete_student_button" type="button"><i class="fa fa-trash"></i></button></div></td></tr>'
                            );
                        });
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }

            $("#student_add_form").on('submit', function(e) {
                e.preventDefault();

                $("#add_student").text('Saving, please wait .....');

                const formData = new FormData();
                formData.append('name', $("#name").val());
                formData.append('email', $("#email").val());
                formData.append('course', $("#course").val());
                formData.append("image", $("#image")[0].files[0]);
                formData.append('password', $("#password").val());
                formData.append('mobile_number', $("#mobile_number").val());
                formData.append('password_confirmation', $("#password_confirmation").val());

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.students.store') }}",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 400) {
                            $('#success_div').hide();
                            $('#errors_div').show();
                            $('#add_student_modal').modal('hide')
                            $.each(response.errors, function(key, err) {
                                $('#errors_list').append(
                                    '<li style="font-weight:bold;">' +
                                    err + '</li>');
                            });
                            $("#add_student").text('Add Student');
                        } else {
                            $('#success_div').show();
                            $('#errors_div').hide();
                            $("#success_msg").text(response.message);
                            $('#add_student_modal').modal('hide')
                            $("#add_student_modal").find("input").val("");
                            $("#add_student").text('Add Student');
                            fetchStudents();
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });

            $(document).on('click', '#edit_student_button', function(e) {
                e.preventDefault();
                const student_id = $(this).val();
                $("#edit_student_modal").modal('show');

                $.ajax({
                    type: "GET",
                    url: "/admin/students/" + student_id,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 404) {
                            $('#errors_div').show();
                            $("#error_msg").text(response.message);
                        } else {
                            $("#student_id").val(student_id);
                            $("#edit_name").val(response.student.name);
                            $("#edit_email").val(response.student.email);
                            $("#edit_mobile_number").val(response.student.mobile_number);
                            $("#edit_course").val(response.student.course);
                            //$("#student_image").html(image_path);
                        }
                    }
                });
            });

            $("#student_edit_form").on('submit', function(e) {
                e.preventDefault();

                $("#update_student_button").text('Updating, please wait .....');

                const student_id = $('#student_id').val();

                const formData = new FormData();
                formData.append('name', $("#edit_name").val());
                formData.append('email', $("#edit_email").val());
                formData.append('course', $("#edit_course").val());
                formData.append("image", $("#edit_image")[0].files[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "/admin/students/" + student_id,
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 400) {
                            $('#errors_div').show();
                            $("#success_div").hide();
                            $('#edit_student_modal').modal('hide')
                            $.each(response.errors, function(key, err) {
                                $('#errors_list').append(
                                    '<li style="font-weight:bold;">' +
                                    err + '</li>');
                            });
                            $("#update_student_button").text('Update Student');
                        } else if (response.status == 404) {
                            $('#errors_div').show();
                            $("#success_div").hide();
                            $('#edit_student_modal').modal('hide')
                            $("#error_msg").text(response.message);
                            $("#update_student_button").text('Update Student');
                        } else {
                            $('#success_div').show();
                            $("#success_msg").text(response.message);
                            $('#edit_student_modal').modal('hide')
                            $("#edit_student_modal").find("input").val("");
                            $("#update_student_button").text('Update Student');
                            fetchStudents();
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });

            $(document).on('click', '#delete_student_button', function(e) {
                e.preventDefault();

                const student_id = $(this).val();

                $("#delete_student_id").val(student_id);

                $("#delete_student_modal").modal('show');
            })

            $(document).on('click', '#delete_student_modal_button', function(e) {
                e.preventDefault();

                $(this).text('Deleting, please wait .....');

                const student_id = $("#delete_student_id").val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/admin/students/" + student_id,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 404) {
                            $('#errors_div').show();
                            $('#delete_student_modal').modal('hide')
                            $("#error_msg").text(response.message);
                            $("#delete_student_modal_button").text('Delete Student');
                        } else {
                            $('#success_div').show();
                            $("#success_msg").text(response.message);
                            $('#delete_student_modal').modal('hide')
                            $("#delete_student_modal_button").text('Delete Student');
                            fetchStudents();
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
