@extends('layout.app')

@section('title')
    Bookings
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
                        <h1>Bookings</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body table-responsive ">
                                @can('view_bookings')
                                    @if(isset($bookings) && $bookings != '' && $bookings != '[]')
                                    <table id="dataTable" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            @can('complete_booking')
                                            <th>Action</th>
                                            @endcan
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Employee</th>
                                            <th>Customer</th>
                                            <th>Services</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($bookings as $key=>$booking)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                @can('complete_booking')
                                                <td>
                                                    <a  @if($booking->status == 1) class="btn btn-outline-success " style="pointer-events: none;" @else class="btn btn-outline-primary " @endif href="{{ route('booking.complete', $booking->id) }}"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                </td>
                                                @endcan
                                                <td>{{$booking->date??'Not Found'}}</td>
                                                <td>{{$booking->time??'Not Found'}}</td>
                                                <td>{{ucwords($booking->user->name??'Not Found')}}</td>
                                                <td>{{ucwords($booking->customer->name??'Not Found')}}</td>
                                                <td>
                                                    @foreach($booking->booking_carts as $booking_cart)
                                                        <span class="badge badge-pill badge-warning">
                                                        {{ucwords($booking_cart->service->name??'Not Found')}}
                                                        </span>
                                                @endforeach
                                                </td>
                                                <td>

                                                    <span class="badge badge-pill @if($booking->status == 1) badge-success @elseif($booking->status == 2) badge-danger @else badge-info @endif ">
                                                    @if($booking->status == 1) Completed @elseif($booking->status == 2) Cancelled @else Pending @endif
                                                </span>
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                        <div class="alert alert-danger mt-3 text-center" role="alert">
                                            No any Booking!
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

