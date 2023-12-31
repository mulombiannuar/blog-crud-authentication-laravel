@extends('layouts.main')
@section('content')
    <!-- Blog Post Content Column -->
    <div class="col-sm-12">
        <!-- Blog Post -->

        <!-- Title -->
        <h1 class="post-title">{{ Str::ucfirst($post->title) }}</h1>

        <!-- Author -->
        <p class="lead">by {{ ucwords($post->user->name) }}</p>

        <hr />

        <!-- Date/Time -->
        <p>
            <span class="glyphicon glyphicon-time"></span> Posted on {{ $post->created_at }}
        </p>

        <hr />
        <img src="{{ asset('assets/images/posts/' . $post->image) }}" class="post-img"
            alt="{{ Str::ucfirst($post->title) }}" />

        <!-- Post Content -->
        <p style="margin-top: 20px;"> {{ $post->body }}</p>

        <hr />

        <!-- Blog Comments -->

        <!-- Comments Form -->
        <div class="well">
            <h4>Leave a Comment:</h4>
            <form role="form">
                <div class="form-group">
                    <textarea class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <hr />

        <!-- Posted Comments -->

        <!-- Comment -->
        <div class="media">
            <a class="pull-left" href="#">
                <img class="media-object" src="http://placehold.it/64x64" alt="" />
            </a>
            <div class="media-body">
                <h4 class="media-heading">
                    Start Bootstrap
                    <small>August 25, 2014 at 9:30 PM</small>
                </h4>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus
                scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum
                in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac
                nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
            </div>
        </div>
    </div>
@endsection
