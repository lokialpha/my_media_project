@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Trend Post Table</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Post Title</th>
                            <th>Image</th>
                            <th>View Count</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($post as $p)
                        <tr>
                            <td> {{ $p['post_id'] }} </td>
                            <td>{{ $p['title'] }}</td>
                            <td>
                                <img class="rounded shadow" height="90px" width="100px"
                                src="@if ($p['image'] == null) {{ asset('defaultImage/default-image.jpg') }}
                                    @else
                                        {{ asset('postImage/' . $p['image']) }} @endif">
                            </td>
                            <td>
                                <i class="fa-solid fa-eye mr-1"></i>
                                <span> {{ $p['post_count'] }} </span>
                            </td>
                            <td>
                                <a href="{{ route('admin#trendPostDetail',$p['post_id']) }}">
                                    <button class="btn btn-lg"><i class="fa-solid fa-file-lines"></i></button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        {{-- <div class=" d-flex justify-content-end">{{ $post->links() }}</div> --}}
    </div>
@endsection
