@extends('layouts.main')
@section('content')
    <!-- Blog Entries Column -->
    <div class="col-sm-10">
        @forelse ($posts as $post)
            <!-- Blog Post Content-->
            <h2 class="post-title">
                <a href="{{ route('blog.show', $post->id) }}">{{ Str::ucfirst($post->title) }}</a>
            </h2>
            <p class="lead">by Author</p>
            <p>
                <span class="glyphicon glyphicon-time"></span> Posted on {{ $post->created_at }}
            </p>
            <img src="{{ asset('assets/images/image1.png') }}" class="post-img-thumbnail"
                alt="{{ Str::ucfirst($post->title) }}" />
            <p>
                {{ $post->description }}
            </p>
            <a class="btn btn-default" href="{{ route('show-post', $post->id) }}">Read More</a>

            <a class="btn btn-success" href="#">Edit Post</a>
            <a class="btn btn-danger" href="#">Delete Post</a>

            <hr />
        @empty
            <div class="alert alert-warning">
                No posts were found
            </div>
        @endforelse
        <!-- Pager -->
        <ul class="pager">
            <li class="previous">
                <a href="#">Prev</a>
            </li>
            <li class="next">
                <a href="#">Next</a>
            </li>
        </ul>
    </div>
    <!-- Side widgets-->
    <div class="col-sm-2">
        <!-- Categories widget-->
        <div class="card mb-4">
            <div class="card-header">Categories</div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    @forelse ($categories as $category)
                        <li><a href="{{ route('home') }}?category_id={{ $category->id }}">{{ $category->name }}</a></li>
                    @empty
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
