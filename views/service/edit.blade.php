@extends('layout.app')

@section('title')
    Edit Service
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
                        <h1>Edit Service</h1>
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
                                @can('update_service')
                                    @if(isset($service) && $service != '' && $service != '[]')
                                    <form action="{{ route('service.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $service->id??'' }}">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Service Name</label>
                                                    <input type="text" required name="name" class="form-control" id="name" placeholder="Service Name" value="{{ $service->name??'' }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                   <div class="col-8">
                                                       <div class="form-group">
                                                           <label for="images">Images</label>
                                                           <input type="file" name="images[]" multiple class="form-control" id="images" accept="image/*">
                                                       </div>
                                                   </div>
                                                   <div class="col-4">
                                                        <button class=" btn btn-outline-primary " style="margin-top: 30px;" data-toggle="modal" data-target="#imageModal" id="imageButton" onclick="event.preventDefault()">Images</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="note">Description</label>
                                                    <textarea required name="note" class="form-control" id="note" placeholder="Description">{{$service->note??''}}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="hour">Minimum Time</label>
                                                   <div class="row ml-1">
                                                       <input type="number" min="0" max="24" required name="hour" class="form-control col-5" id="hour" placeholder="Hour" value="{{ $service->minimum_hour??'' }}">
                                                       <input type="number" min="0" max="60" required name="minute" class="form-control col-5 ml-2" id="minute" placeholder="Minute" value="{{ $service->minimum_minutes??'' }}">
                                                   </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="parent" class="font-medium-1">Category: </label>
                                                <select class=" form-control" name="category_id"  id="category_id" required>
                                                    <option value=""> Category</option>
                                                    @if(isset($categories) && $categories != null)
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" @if($category->id??'' == $service->category->id) selected @endif>{{ ucwords($category->name??'unknown') }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <input type="checkbox" id="consent" value="1" name="consent" @if($service->consent_form == 1) checked @endif>
                                                <label for="consent" class="font-medium-1">Consent Form Required</label>

                                            </div>
                                            <div class="col-md-6">
                                                <label for="start_time" class="font-medium-1" >Special Time Limitation</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="start_time" class="font-medium-1" >From</label>
                                                        <input type="time" id="start_time" name="start_time" class="form-control" value="{{$service->start_time??''}}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="end_time" class="font-medium-1" >To</label>
                                                        <input type="time" id="end_time" name="end_time" class="form-control" value="{{$service->end_time??''}}">
                                                    </div>
                                                </div>




                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary"> <i class="fa fa-cloud" aria-hidden="true"></i>&nbsp;Save</button>
                                    </form>
                                    @else
                                    Service not found!
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

    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog" style="width: 80vw !important; max-width: none !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Image Manager</h6>
                    <button type="button" class="btn-close border-0 text-danger bg-transparent" data-dismiss="modal" aria-label="Close"  id="imageModalClose" >
                        Close
                    </button>
                </div>
                <div class="modal-body overflow-hidden">
                    @if(isset($service) && $service != '' && $service != '[]')
                        @foreach($service->images as $image)
                            <div class="bg-light d-inline-flex m-1" style="width:250px;">
                                <img class="rounded" src="{{ asset('upload/service/'.$service->id.'/'.$image->name??'') }}" alt="service image" style="width: 100%;height: 250px;">
                            </div>
                        @endforeach
                    @else
                    No images!
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="{{asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

@endsection

