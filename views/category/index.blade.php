@extends('layout.app')

@section('title')
    Categories
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
                        <h1>Categories</h1>
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
                                @can('create_category')
                                <a class="btn btn-primary" href="{{ route('category.create') }}"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;Add Category</a>
                                @endcan
                                @can('view_categories')
                                    @if($categories != null && $categories != '' && $categories != '[]')
                                    <table id="dataTable" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            @can('active_category', 'inactive_category', 'update_category', 'delete_category')
                                                <th>Action</th>
                                            @endcan
                                            <th>Name</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($categories as $key=>$category)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                @can('inactive_category', 'active_category', 'update_category', 'delete_category')
                                                <td>
                                                    @if($category->status??'' == 1)
                                                        @can('inactive_category')
                                                        <a class="btn btn-outline-primary " href="{{ route('category.inactive', $category->id) }}"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                                        @endcan
                                                    @else
                                                        @can('active_category')
                                                        <a class="btn btn-outline-primary " href="{{ route('category.active', $category->id) }}"><i class="fa fa-lock-open" aria-hidden="true"></i></a>
                                                        @endcan
                                                    @endif
                                                    @can('update_category')
                                                        <a class="btn btn-outline-primary " href="{{ route('category.edit', $category->id) }}"><i class="fa fa-cloud" aria-hidden="true"></i></a>
                                                    @endcan
                                                    @can('delete_category')
                                                        <span class="ml-1">
                                                            <button class="btn btn-icon rounded-3 border border-danger text-danger delete" value="{{ $category->id }}">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>

                                                            <form action="{{ route('category.delete') }}" method="post" id="delete-form-{{ $category->id }}">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $category->id }}">
                                                            </form>
                                                        </span>
                                                    @endcan
                                                </td>
                                                @endcan
                                                <td>{{$category->name??''}}</td>
                                                <td>

                                                    <span class="badge badge-pill @if($category->status??'' == 1) badge-success @else badge-danger @endif ">
                                                        @if($category->status??'' == 1) Active @else Inactive @endif
                                                    </span>
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                        <div class="alert alert-danger mt-3 text-center" role="alert">
                                            No any Category!
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
                text: "This category will delete as permanently.",
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

