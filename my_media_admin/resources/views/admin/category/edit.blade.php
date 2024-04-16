@extends('admin.layouts.app')

@section('content')
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <a href="{{ route('admin#category') }}"><h3><i class="fa-solid fa-circle-left text-dark mt-2"></i></h3></a>
                    <h4 class="ml-3 mt-2">Category Edit Page</h4>
                </div>
                <hr>
                <form action="{{ route('admin#categoryUpdate',$data['category_id']) }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="text" class="form-control" value="{{ old('categoryName',$data['title']) }}" name="categoryName" placeholder="Enter Category Name...">
                        @error('categoryName')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Description</label>
                        <textarea class="form-control" name="categoryDescription" rows="5" placeholder="Enter Description...">{{ old('categoryDescription',$data['description']) }}</textarea>
                        @error('categoryDescription')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn bg-dark text-white offset-9 col-3">Update</button>
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
                            <input type="text" name="categorySearchKey" class="form-control float-right" placeholder="Search">

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
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Created Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category as $c)
                        <tr>
                            <td>{{ $c['category_id'] }}</td>
                            <td>{{ $c['title'] }}</td>
                            <td>{{ $c['description'] }}</td>
                            <td>{{ $c['created_at'] }}</td>
                            <td>
                                <a href="{{ route('admin#categoryEditPage',$c['category_id']) }}">
                                    <button class="btn btn-sm bg-dark text-white"><i class="fas fa-edit"></i></button>
                                </a>
                                <a href="{{ route('admin#deleteCategory',$c['category_id']) }}">
                                    <button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button>
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
