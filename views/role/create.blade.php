@extends('layout.app')

@section('title')
    Create Role
@endsection

@section('page-style')
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Role</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                @can('create_role')
                                <form action="{{ route('role.store') }}" method="POST">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Role Name</label>
                                                <input type="text" required name="name" class="form-control" id="name" placeholder="Roll Name">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Description</label>
                                                <textarea name="note" id="note" class="form-control" placeholder="Description"></textarea>
                                            </div>
                                        </div>

                                        <h6>Permissions</h6>
                                        <div class="col-md-12">
                                            <div class="row">
                                                @if(isset($permissions) && $permissions != '' && $permissions != '[]')
                                                    @foreach($permissions as $permission)
                                                        <div class="col-2">
                                                            <input type="checkbox" name="permissions[]" id="permission-{{$permission->id??''}}" value="{{ $permission->id??'' }}">
                                                            <label for="permission-{{$permission->id??''}}">{{ ucwords($permission->display_name??'') }}</label>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    No any permissions!
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;Create</button>
                                </form>
                                @endcan
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('page-script')
    <script src="{{asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

@endsection

