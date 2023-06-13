@extends('layout.app')

@section('title')
    Dashboard
@endsection

@section('page-style')
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    @can('view_bookings')
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $booking_count??0 }}</h3>

                                <p>Bookings</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('bookings') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @endcan
                    <!-- ./col -->
                        @can('view_services')
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $service_count??0 }}</h3>

                                <p>Services</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('services') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                        @endcan
                    <!-- ./col -->
                        @can('view_customers')
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $customer_count??0 }}</h3>

                                <p>Customers</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('customers')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                        @endcan
                    <!-- ./col -->
                        @can('view_users')
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $user_count??0 }}</h3>

                                <p>Users</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person"></i>
                            </div>
                            <a href="{{ route('users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                        @endcan
                    <!-- ./col -->
                </div>
            </div>
        </section>
        <!-- /.content -->
        <!-- Main content -->
        @can('view_bookings')
        <section class="content">
            <div class="container-fluid">
                <h5>Latest Bookings</h5>
                @if(isset($bookings) && $bookings != '' && $bookings != '[]')
                    <table id="dataTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
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

                                                <span class="badge badge-pill @if($booking->status??'' == 1) badge-success @else badge-danger @endif ">
                                                    @if($booking->status??'' == 1) Completed @else Pending @endif
                                                </span>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-danger mt-3 text-center" role="alert">
                        No any latest bookings!
                    </div>
                @endif
            </div>
        </section>
        @endcan
        @can('view_customers')
        <section class="content">
            <div class="container-fluid">
                <h5>New Customers</h5>
                @if($customers != null && $customers != '' && $customers != '[]')
                    <table id="dataTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $key=>$customer)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{$customer->name??''}}</td>
                                <td>{{$customer->email??''}}</td>
                                <td>{{$customer->mobile??''}}</td>
                                <td>

                                                <span class="badge badge-pill @if($customer->status??'' == 1) badge-success @else badge-danger @endif ">
                                                    @if($customer->status??'' == 1) Active @else Inactive @endif
                                                </span>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-danger mt-3 text-center" role="alert">
                        No any Customers!
                    </div>
                @endif
            </div>
        </section>
        @endcan
    </div>
@endsection

@section('page-script')
@endsection

