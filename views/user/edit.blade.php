@extends('layout.app')

@section('title')
    Edit Users
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
                        <h1>Edit Users</h1>
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
                                @can('update_user')
                                    @if(isset($user))
                                    <form action="{{ route('user.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Full Name</label>
                                                    <input type="text" required name="name" class="form-control" id="name" placeholder="Full Name" value="{{ $user->name }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email address</label>
                                                    <input type="email" required name="email" class="form-control" id="email" placeholder="Email Address"  value="{{ $user->email }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mobile">Mobile Number</label>
                                                    <input type="tel" required name="mobile" class="form-control" id="mobile" placeholder="Mobile Number"  value="{{ $user->mobile }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="role">User Role</label>
                                                    <select name="role" id="role" class="form-control">
                                                        <option value="" selected> -Select Role-</option>
                                                        @if(isset($roles) && $roles != '' && $roles != '[]')
                                                            @foreach($roles as $role)
                                                                <option value="{{$role->id}}" @if($user->roles[0]->id == $role->id) selected @endif>{{ucwords($role->name??'Unknown')}}</option>
                                                            @endforeach
                                                        @else
                                                            <option value=""> -No any roles-</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-cloud" aria-hidden="true"></i>&nbsp;Save</button>
                                    </form>
                                    @else
                                        User not found
                                    @endif
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

