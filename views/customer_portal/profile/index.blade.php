@extends('layout.customer_app')

@section('title')
    Manage Profile
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
                        <h1>Manage Profile</h1>
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
                                    <form action="{{ route('customer-profile.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ auth()->guard('customer')->user()->id }}">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Full Name</label>
                                                    <input type="text" required name="name" class="form-control" id="name" placeholder="Full Name" value="{{ auth()->guard('customer')->user()->name }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email address</label>
                                                    <input type="email" required name="email" class="form-control" id="email" placeholder="Email Address"  value="{{ auth()->guard('customer')->user()->email }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mobile">Mobile Number</label>
                                                    <input type="tel" required name="mobile" class="form-control" id="mobile" placeholder="Mobile Number"  value="{{ auth()->guard('customer')->user()->mobile }}">
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

