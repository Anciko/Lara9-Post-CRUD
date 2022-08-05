@extends('master')

@section('title', 'Edit')

@section('content')
    <div class="my-5 py-5">
        <div class="col-md-6 mx-auto">
            <a href="{{ route('post.index') }}" class="btn btn-dark btn-sm mb-2">
                <- Back </a>
                    <div class="card p-4">
                        <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror mb-1" name="title" value="{{ old('title', $post->title) }}" >
                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control mb-1 @error('description') is-invalid @enderror" id="description"
                                    cols="30" rows="5">{{ old('description', $post->description) }}</textarea>
                                @error('description')
                                    <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="image">Choose Image</label> <br>
                                <a href="{{ asset('storage/image/' . $post->image) }}"> {{ $post->image }}</a>
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
        </div>
    </div>
@endsection
