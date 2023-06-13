@extends('layout.app')

@section('title')
    Roles
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
                        <h1>Roles</h1>
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
                                <a class="btn btn-primary" href="{{ route('role.create') }}"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;Add Role</a>
                                @endcan
                                    @can('view_roles', 'update_role', 'delete_role', 'active_role', 'inactive_role')
                                    @if($roles != null && $roles != '' && $roles != '[]')
                                    <table id="dataTable" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            @can('update_role', 'delete_role')
                                            <th>Action</th>
                                            @endcan
                                            <th>Name</th>
                                            <th>Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($roles as $key=>$role)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                @can('update_role', 'delete_role')
                                                <td>
                                                    @can('update_role')
                                                    <a class="btn btn-outline-primary " href="{{ route('role.edit', $role->id) }}"><i class="fa fa-cloud" aria-hidden="true"></i></a>
                                                    @endcan
                                                    @can('delete_role')
                                                    <span class="ml-1">
                                                    <button class="btn btn-icon rounded-3 border border-danger text-danger delete" value="{{ $role->id }}">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>

                                                    <form action="{{ route('role.delete') }}" method="post" id="delete-form-{{ $role->id }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $role->id }}">
                                                    </form>

                                                </span>
                                                        @endcanany
                                                </td>
                                                @endcan
                                                <td>{{ucwords($role->name??'')}}</td>
                                                <td>{{$role->note??''}}</td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-danger mt-3 text-center" role="alert">
                                        No any Roles!
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
                text: "This role will delete as permanently.",
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

