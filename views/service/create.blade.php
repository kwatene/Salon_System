@extends('layout.app')

@section('title')
    Create Service
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
                        <h1>Create Service</h1>
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
                                @can('create_service')
                                <form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Service Name</label>
                                                <input type="text" required name="name" class="form-control" id="name" placeholder="Service Name">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="images">Images</label>
                                                <input type="file" required name="images[]" multiple class="form-control" id="images" accept="image/*">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="note">Description</label>
                                                <textarea required name="note" class="form-control" id="note" placeholder="Description"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="hour">Minimum Time</label>
                                               <div class="row ml-1">
                                                   <input type="number" min="0" max="24" required name="hour" class="form-control col-5" id="hour" placeholder="Hour">
                                                   <input type="number" min="0" max="60" required name="minute" class="form-control col-5 ml-2" id="minute" placeholder="Minute">
                                               </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="parent" class="font-medium-1">Category: </label>
                                            <select class=" form-control" name="category_id"  id="category_id" required>
                                                <option value=""> Category</option>
                                                @if(isset($categories) && $categories != null)
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" >{{ ucwords($category->name??'unknown') }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <input type="checkbox" id="consent" name="consent" value="1">
                                            <label for="consent" class="font-medium-1" >Consent Form Required</label>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="start_time" class="font-medium-1" >Special Time Limitation</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="start_time" class="font-medium-1" >From</label>
                                                    <input type="time" id="start_time" name="start_time" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="end_time" class="font-medium-1" >To</label>
                                                    <input type="time" id="end_time" name="end_time" class="form-control">
                                                </div>
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

