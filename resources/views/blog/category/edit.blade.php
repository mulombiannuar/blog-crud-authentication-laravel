@extends('layouts.main')
@section('content')
    <div class="col-lg-12 newpost">
        <!-- Title -->
        <h1>{{ $category->name }}</h1>

        <!-- Newpost form -->
        <form action="{{ route('admin.categories.update', $category->id) }}" method="post" class="newpost-form">
            @method('put')
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter category name"
                    autocomplete="off" value="{{ $category->name }}" />
            </div>

            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
        <!-- /form -->
    </div>
@endsection
