@extends('layouts.main')
@section('content')
    <!-- Blog Entries Column -->
    <div class="col-sm-12">
        @forelse ($posts as $post)
            <!-- Blog Post Content-->
            <h2 class="post-title">
                <a href="{{ route('show-post', $post->id) }}">{{ Str::ucfirst($post->title) }}</a>
            </h2>
            <p class="lead">by Author</p>
            <p>
                <span class="glyphicon glyphicon-time"></span> Posted on {{ $post->created_at }}
            </p>
            <img src="{{ asset('assets/images/posts/' . $post->image) }}" class="post-img-thumbnail"
                alt="{{ Str::ucfirst($post->title) }}" />
            <p>
                {{ $post->description }}
            </p>
            <a class="btn btn-default" href="{{ route('show-post', $post->id) }}">Read More</a>
            @auth()
                <a class="btn btn-success" href="{{ route('posts.edit', $post->id) }}">Edit Post</a>
                <form style="display: inline" action="{{ route('posts.destroy', $post->id) }}" method="post"
                    onclick="return confirm('Do you really want to delete this post?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Post
                    </button>
                </form>
            @endauth

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
    <div class="col-sm-12">
        <!-- Categories widget-->
        <div class="card mb-4">
            <div class="card-header">Categories</div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    @forelse ($categories as $category)
                        <li><a href="{{ route('home') }}?category_id={{ $category->id }}">{{ $category->name }}</a></li>
                    @empty
                        <div class="alert alert-danger">
                            No Categories could be found
                        </div>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
