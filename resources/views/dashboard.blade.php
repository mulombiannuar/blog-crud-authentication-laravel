@extends('layouts.main')
@section('content')
    <!-- /.container -->
    <div class="col-sm-12" style="margin-top:20px;">
        <ul class="nav nav-pills">
            <li class="active">
                <a href="#users" data-toggle="tab">Manage Users</a>
            </li>
            <li><a href="#posts" data-toggle="tab">Manage Posts</a></li>
            <li><a href="#categories" data-toggle="tab">Manage Categories</a></li>
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
        </div>
    </div>
@endsection
