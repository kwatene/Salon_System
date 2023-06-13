@extends('layout.app')

@section('title')
    Create Category
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
                        <h1>Create Category</h1>
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
                                <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" class="font-medium-1 form-label" >Category Name: </label>
                                            <input type="text" id="name" class=" form-control " placeholder="Category Name" name="name" required="required">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="parent" class="font-medium-1">Parent Category: </label>
                                            <select class=" form-control" name="parent_id"  id="parent">
                                                <option value=""> Parent Category</option>
                                                @if(isset($categories) && $categories != null)
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ ucwords($category->name??'unknown') }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4"> <i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;Create</button>
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

