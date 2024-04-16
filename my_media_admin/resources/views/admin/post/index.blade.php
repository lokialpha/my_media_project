@extends('admin.layouts.app')

@section('content')
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h4>Post Page</h4>
                <hr>
                <form action="{{ route('admin#postCreate') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Post Title</label>
                        <input type="text" class="form-control" value="{{ old('postTitle') }}" name="postTitle" placeholder="Enter Post Name...">
                        @error('postTitle')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Description</label>
                        <textarea class="form-control" name="postDescription" rows="5" placeholder="Enter Description...">{{ old('postDescription') }}</textarea>
                        @error('postDescription')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Post Image</label>
                        <input type="file" class="form-control" name="postImage" placeholder="Enter Post Name...">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category</label>
                        <select name="postCategory" class=" form-control">
                            <option value="">Choose Category</option>
                            @foreach ($category as $c)
                                <option value="{{ $c['category_id'] }}">{{ $c['title'] }}</option>
                            @endforeach
                        </select>
                        @error('postCategory')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary offset-9 col-3">Create</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-8">
        {{-- start alert for delete --}}
        @if (Session::get('deleteSuccess'))
            <div class="alert bg-gradient-success text-white alert-dismissible fade show" role="alert">
                {{ Session::get('deleteSuccess') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        {{-- end alert for delete --}}
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <form action="{{ route('admin#categorySearch') }}" method="post">
                        @csrf
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="categorySearchKey" class="form-control float-right"
                                placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($post as $p)
                            <tr>
                                <td>{{ $p['post_id'] }}</td>
                                <td>{{ $p['title'] }}</td>
                                <td><img class="rounded shadow" height="90px" width="100px"
                                        src="@if ($p['image'] == null) {{ asset('defaultImage/default-image.jpg') }}
                                            @else
                                                {{ asset('postImage/' . $p['image']) }}
                                            @endif"
                                ></td>
                                <td>
                                    <a href="{{ route('admin#postEditPage', $p['post_id']) }}">
                                        <button class="btn btn-sm bg-dark text-white"><i class="fas fa-edit"></i></button>
                                    </a>
                                    <a href="{{ route('admin#postDelete', $p['post_id']) }}">
                                        <button class="btn btn-sm bg-danger text-white"><i
                                                class="fas fa-trash-alt"></i></button>
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
    </div>
@endsection
