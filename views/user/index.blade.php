@extends('layout.app')

@section('title')
    Users
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
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
                                @can('create_user')
                                <a class="btn btn-primary" href="{{ route('user.create') }}"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;Add User</a>
                                @endcan
                                @can('view_users')
                                    @if($users != null && $users != '' && $users != '[]')
                                    <table id="dataTable" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            @can('update_user', 'delete_user', 'inactive_user', 'active_user')
                                            <th>Action</th>
                                            @endcan
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $key=>$user)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                @can('update_user', 'delete_user', 'inactive_user', 'active_user')
                                                <td>
                                                    @if($user->status??'' == 1)
                                                        @can('inactive_user')
                                                        <a class="btn btn-outline-primary " href="{{ route('user.inactive', $user->id) }}"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                                        @endcan
                                                    @else
                                                        @can('active_user')
                                                        <a class="btn btn-outline-primary " href="{{ route('user.active', $user->id) }}"><i class="fa fa-lock-open" aria-hidden="true"></i></a>
                                                        @endcan
                                                    @endif

                                                    @can('update_user')
                                                        <a class="btn btn-outline-primary " href="{{ route('user.edit', $user->id) }}"><i class="fa fa-cloud" aria-hidden="true"></i></a>
                                                    @endcan
                                                    @can('delete_user')
                                                        <span class="ml-1">
                                                            <button class="btn btn-icon rounded-3 border border-danger text-danger delete" value="{{ $user->id }}">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>

                                                            <form action="{{ route('user.delete') }}" method="post" id="delete-form-{{ $user->id }}">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                            </form>
                                                        </span>
                                                    @endcan
                                                </td>
                                                @endcan
                                                <td>{{$user->name??''}}</td>
                                                <td>{{$user->email??''}}</td>
                                                <td>{{$user->mobile??''}}</td>
                                                <td>

                                                    <span class="badge badge-pill @if($user->status??'' == 1) badge-success @else badge-danger @endif ">
                                                        @if($user->status??'' == 1) Active @else Inactive @endif
                                                    </span>
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                        <div class="alert alert-danger mt-3 text-center" role="alert">
                                            No any Users!
                                        </div>
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
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert/sweetalert.all.min.js') }}"></script>
    <script>
        $(function () {
            $("#dataTable").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
        });
        });
        $('.delete').on('click', function() {
            var Id = $(this).val();
            Swal.fire({
                title: 'Are you sure?',
                text: "This user will delete as permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    document.getElementById('delete-form-'+Id).submit();
                }
            });
        });

    </script>
@endsection

