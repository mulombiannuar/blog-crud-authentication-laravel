@extends('layouts.main')
@section('content')
    <div class="col-lg-2"></div>

    <!-- Signup content  -->
    <div class="col-lg-8">
        <!-- Title -->
        <h1>{{ $title }}</h1>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-sm-12 ">
                <img width="100px" src="{{ asset('assets/images/users/' . $user->user_image) }}" alt=""
                    class="img-rounded img-responsive" />
                <form action="{{ route('admin.users.photo', $user->id) }}" class="signup-form" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="user_image">User Image</label>
                        <input type="file" id="user_image" name="user_image" class="form-control" required />
                    </div>
                    <button type="submit" class="btn btn-warning">Upload New Photo</button>
                </form>
            </div>
        </div>
        <!-- Login form -->
        <form action="{{ route('admin.users.update', $user->id) }}" method="post" class="signup-form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Full name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}"
                    placeholder="Enter full name" autocomplete="off" autofocus required />
                @error('name')
                    <span class="text text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="emil">Email Address </label>
                <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}"
                    placeholder="Enter email address" autocomplete="off" required />
                @error('email')
                    <span class="text text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="emil">Mobile Number </label>
                <input type="number" id="mobile_number" name="mobile_number" value="{{ $user->mobile_number }}"
                    class="form-control" placeholder="Enter mobile number" autocomplete="off" required />
                @error('mobile_number')
                    <span class="text text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Role</label>
                <select class="form-control" name="user_role" id="user_role" name="user_role">
                    <option value="{{ $user_role->id }}">{{ $user_role->name }}</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}"> {{ $role->name }} </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update User Data</button>
        </form>
        <!-- /form -->
    </div>

    <div class="col-lg-2"></div>
@endsection
