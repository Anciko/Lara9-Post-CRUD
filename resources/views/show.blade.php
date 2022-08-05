@extends('master')

@section('title', 'Detail')

@section('content')
    <div class="my-5 py-5">
        <div class="col-md-4 mx-auto">

            <a href="{{ route('post.index') }}" class="btn btn-dark btn-sm mb-2">
                <- Back </a>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5>{{ $post->title }}</h5>
                            <small>{{ $post->updated_at }}</small>
                        </div>
                        <div class="card-body">
                            <small>Status - {!! $post->status !!} </small>
                            <div><img src="{{ $post->post_image_path }}" alt="" class="img-fluid" width="100"></div>
                            <p>{{ $post->description }}</p>
                            <small class="text-muted">{{ $post->time }}</small>
                        </div>
                    </div>

        </div>
    </div>
@endsection
