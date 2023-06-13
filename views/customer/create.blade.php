@extends('layout.app')

@section('title')
    Create Customers
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
                        <h1>Create Customers</h1>
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
                                @can('create_customer')
                                <form action="{{ route('customer.store') }}" method="POST">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Full Name</label>
                                                <input type="text" required name="name" class="form-control" id="name" placeholder="Full Name">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email address</label>
                                                <input type="email" required name="email" class="form-control" id="email" placeholder="Email Address">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mobile">Mobile Number</label>
                                                <input type="tel" required name="mobile" class="form-control" id="mobile" placeholder="Mobile Number">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" required name="password" class="form-control" id="password" placeholder="Password">
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

