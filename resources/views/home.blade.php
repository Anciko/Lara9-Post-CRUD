@extends('master')

@section('title', 'Todo')
@section('content')
    <div class="container mt-3">
        <div class="row">
            <!------- Left column --------->
            <div class="col-md-4">
                <h3 class="text-info text-center">Create Post</h3>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{ route('post.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="title">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror mb-1" name="title" value="{{ old('title') }}" >
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control mb-1 @error('description') is-invalid @enderror" id="description"
                            cols="30" rows="5">{{ old('description') }}</textarea>
                        @error('description')
                            <small class="text-danger"> {{ $message }} </small>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="image">Choose Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <div class="form-group mb-3">
                        <label for="priority">Proiority</label>
                        <select class="form-select" name="status">
                            <option value="low">Low</option>
                            <option value="middle">Middle</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <button class="btn btn-info text-white rounded-0 w-100">Confirm</button>
                </form>
            </div>
            <!-------- Right column ------>
            <div class="col-md-8">
                <div class="p-4">
                    <form action="{{ route('post.index') }}" method="GET">
                        <input type="text" class="form-control" name="searchKey" placeholder="Search Post..." value="{{ request('searchKey') }}">
                    </form>
                </div>
                <h3 class="text-dark">Total - {{ $posts->total() }} </h3>
                <div class="row">
                    @if (count($posts) != 0)
                        @foreach ($posts as $post)
                            <div class="col-md-6">
                                <div class="card mb-3 bg-light shadow p-2">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="text-primary">{{ $post->title }}</h5>
                                        <small class="text-muted">{{ $post->updated_at }}</small>
                                    </div>
                                    <div class="mb-1">
                                        <small>Status - {!! $post->status !!}</small>
                                    </div>
                                    <p>{{ Str::of($post->description)->words(10, '...') }}</p>
                                    <small class="text-muted mb-1">{{ $post->time }}</small>
                                    <div class="card-footer d-flex justify-content-end gap-1">
                                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-warning"> <i class="fa fa-edit"></i> </a>
                                        <a href="{{ route('post.show', $post->id) }}" class="btn btn-sm btn-info"> <i class="fa fa-info-circle"></i>
                                        </a>
                                        <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit"> <i class="fa fa-trash"></i> </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h4 class="text-muted">No Posts Found Here!</h4>
                    @endif

                </div>
                {{ $posts->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
