@extends('admin.layouts.app')

@section('content')
    <div class="col-12">
        {{-- start alert for update --}}
        <div class="offset-9 col-3">
            @if (Session::get('deleteSuccess'))
                <div class="alert bg-gradient-danger text-white alert-dismissible fade show" role="alert">
                    {{ Session::get('deleteSuccess') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        {{-- end alert for update --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Admin List Page</h3>

                <div class="card-tools">
                    <form action="{{ route('admin#searchList') }}" method="post">
                        @csrf
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="adminSearchKey" class="form-control float-right" placeholder="Search">

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
                            <th>Admin Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Gender</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userData as $d)
                            <tr>
                                <td>{{ $d['id'] }}</td>
                                <td>{{ $d['name'] }}</td>
                                <td>{{ $d['email'] }}</td>
                                <td>{{ $d['phone'] }}</td>
                                <td>{{ $d['address'] }}</td>
                                <td>{{ $d['gender'] }}</td>
                                <td>
                                    {{-- <button class="btn btn-sm bg-dark text-white"><i class="fas fa-edit"></i></button> --}}
                                    @if (auth()->user()->id != $d['id'])
                                        <a
                                            @if (count($userData) == 1) href="#"
                                            @else href="{{ route('admin#deleteAccount', $d['id']) }}" @endif>
                                                <button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button>
                                        </a>
                                    @endif
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
