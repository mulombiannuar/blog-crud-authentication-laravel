@extends('layouts.main')
@section('content')
    <div class="col-lg-12 newpost">
        <!-- Title -->
        <h1>New Category</h1>

        <!-- Newpost form -->
        <form action="{{ route('admin.categories.store') }}" method="post" class="newpost-form">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control"
                    placeholder="Enter category name" autocomplete="off" required />
            </div>

            <button type="submit" class="btn btn-primary">Save Category</button>
        </form>
        <!-- /form -->
    </div>
@endsection
