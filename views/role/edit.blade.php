@extends('layout.app')

@section('title')
    Edit Role
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
                        <h1>Edit Role</h1>
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
                                @if(isset($role) && $role != '' && $role != '[]')
                                    @can('update_role')
                                <form action="{{ route('role.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$role->id??''}}">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Role Name</label>
                                                <input type="text" required name="name" class="form-control" id="name" placeholder="Roll Name" value="{{ $role->name??'' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Description</label>
                                                <textarea name="note" id="note" class="form-control" placeholder="Description">{{$role->note??''}}</textarea>
                                            </div>
                                        </div>

                                        <h6>Permissions</h6>
                                        <div class="col-md-12">
                                            <div class="row">
                                                @if(isset($permissions) && $permissions != '' && $permissions != '[]')
                                                    @foreach($permissions as $permission)
                                                        <div class="col-2">
                                                            <input type="checkbox" name="permissions[]" id="permission-{{$permission->id??''}}" value="{{ $permission->id??'' }}"
                                                            @foreach($role->permissions as $role_permission)
                                                                @if($role_permission->id == $permission->id)
                                                                    checked
                                                                @endif
                                                            @endforeach
                                                            >
                                                            <label for="permission-{{$permission->id??''}}">{{ ucwords($permission->display_name??'') }}</label>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    No any permissions!
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-cloud" aria-hidden="true"></i>&nbsp;Save</button>
                                </form>
                                    @endcan
                                @else
                                    Role not found!
                                @endif
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

