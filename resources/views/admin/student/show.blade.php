@extends('layouts.main')
@section('content')
    <div class="col-lg-12">
        <!-- Title -->
        <h1>Profile Page</h1>

        <hr />

        <!-- User Profile -->
        <div class="well well-sm">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <img src="{{ asset('assets/images/users/' . $user->user_image) }}" alt="{{ $user->name }}"
                        class="img-rounded img-responsive" />
                </div>
                <div style="margin-top: 30px" class="col-sm-6 col-md-8">
                    <h4>{{ Str::upper($user->name) }}</h4>
                    <p>
                        <i class="glyphicon glyphicon-envelope"></i>{{ $user->email }}
                        <br />
                        <i class="glyphicon glyphicon-phone"></i>{{ $user->mobile_number }}
                        <br />
                        <i class="glyphicon glyphicon-gift"></i>{{ $user->created_at }}
                    </p>
                    <!-- Split button -->
                    <div class="">
                        <a href="{{ route('admin.users.edit', $user->id) }}">
                            <button type="button" class="btn btn-primary">
                                <i class="fa fa-edit"></i> Update
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <hr />
    </div>
@endsection
