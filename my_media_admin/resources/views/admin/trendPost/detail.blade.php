@extends('admin.layouts.app')

@section('content')
    <div class="col-6 offset-3 mt-5">
        <div class="card">
            <i class="fa-solid fa-circle-chevron-left mt-3 ml-3 fa-2x" onclick="history.back()"></i>
            <div class="card-header">
                <div class="text-center">
                    <img class="rounded shadow" width="300px"
                    src="@if ($post['image'] == null) {{ asset('defaultImage/default-image.jpg') }}
                        @else
                            {{ asset('postImage/' . $post['image']) }} @endif">
                </div>
            </div>
            <div class="card-body">
                <h1 class="text-center">{{ $post['title'] }}</h1>
                <p class="text-center">{{ $post['description'] }}</p>
            </div>
        </div>
    </div>
@endsection
