@extends('layouts.main')
@section('content')
    <div class="col-lg-12 newpost">
        <!-- Title -->
        <h1>{{ $title }}</h1>

        <!-- Newpost form -->
        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" class="newpost-form">
            @csrf
            <div class="form-group">
                <label for="name">Post Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control"
                    placeholder="Enter post title" autocomplete="off" required />
            </div>
            <div class="form-group">
                <label for="name">Post Description</label>
                <input type="text" id="description" name="description" value="{{ old('description') }}"
                    class="form-control" placeholder="Enter post description" autocomplete="off" required />
            </div>
            <div class="form-group">
                <label for="name">Post Category</label>
                <select class="form-control" name="category_id" id="category_id" name="category_id" required>
                    <option value="">Select Post Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"> {{ $category->name }} </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="post_image">Post Image</label>
                <input type="file" id="post_image" name="post_image" class="form-control" />
            </div>

            <div class="form-group">
                <label for="body">Post Body</label>
                <textarea rows="5" id="body" name="body" value="{{ old('body') }}" class="form-control" required
                    placeholder="Enter post body"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Post</button>
        </form>
        <!-- /form -->
    </div>
@endsection
