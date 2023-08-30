@extends('layouts.main')
@section('content')
    <div class="col-lg-2"></div>

    <!-- Signup content  -->
    <div class="col-lg-8 signup">
        <!-- Title -->
        <h1>{{ $title }}</h1>

        <!-- Login form -->
        <form action="{{ route('admin.users.store') }}" enctype="multipart/form-data" method="post" class="signup-form">
            @csrf
            <input type="hidden" name="password" value="{{ $password }}">
            <input type="hidden" name="password_confirmation" value="{{ $password }}">
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
                <label for="name">Role</label>
                <select class="form-control" name="user_role" id="user_role" name="user_role">
                    <option value="">Select User Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}"> {{ $role->name }} </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">{{ $title }}</button>
        </form>
        <!-- /form -->
    </div>

    <div class="col-lg-2"></div>
@endsection
