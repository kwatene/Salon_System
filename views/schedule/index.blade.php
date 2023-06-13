@extends('layout.app')

@section('title')
    Schedule
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
                        <h1>Schedule</h1>
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
                                @can('view_schedule')
                                <form @can('update_schedule') action="{{ route('schedule.update') }}" @endcan method="POST">
                                    @csrf
                                    <div class="row">

                                        <div class="col-6">
                                            <h6>Date range</h6>
                                           <div class="row">
                                               <div class="col-6">
                                                   <div class="form-group">
                                                       <label for="start_date">Start Date</label>
                                                       <input type="date" required name="start_date" class="form-control" id="start_date" value="{{ $schedule->start_date??'' }}">
                                                   </div>
                                               </div>
                                               <div class="col-6">
                                                   <div class="form-group">
                                                       <label for="end_date">End Date</label>
                                                       <input type="date" required name="end_date" class="form-control" id="end_date" value="{{ $schedule->end_date??'' }}">
                                                   </div>
                                               </div>
                                           </div>
                                        </div>

                                        <div class="col-6">
                                            <h6>Time range (Day)</h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="open_time">Open Time</label>
                                                        <input type="time" required name="open_time" class="form-control" id="open_time" value="{{ $schedule->open_time??'' }}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="close_time">Close Time</label>
                                                        <input type="time"  required name="close_time" class="form-control" id="close_time" value="{{ $schedule->close_time??'' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <h6>Working Days</h6>
                                            <div class="row">
                                                <div class="col-2">
                                                    <input type="checkbox" name="monday" id="monday" value="1" @if($schedule->monday??'' == 1) checked @endif>
                                                    <label for="monday">Monday</label>
                                                </div>

                                                <div class="col-2">
                                                    <input type="checkbox" name="tuesday" id="tuesday" value="1" @if($schedule->tuesday??'' == 1) checked @endif>
                                                    <label for="tuesday">Tuesday</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" name="wednesday" id="wednesday" value="1" @if($schedule->wednesday??'' == 1) checked @endif>
                                                    <label for="wednesday">Wednesday</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" name="thursday" id="thursday" value="1" @if($schedule->thursday??'' == 1) checked @endif>
                                                    <label for="thursday">Thursday</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" name="friday" id="friday" value="1" @if($schedule->friday??'' == 1) checked @endif>
                                                    <label for="friday">Friday</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" name="saturday" id="saturday" value="1" @if($schedule->saturday??'' == 1) checked @endif>
                                                    <label for="saturday">Saturday</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" name="sunday" id="sunday" value="1" @if($schedule->sunday??'' == 1) checked @endif>
                                                    <label for="sunday">Sunday</label>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                    @can('update_schedule')
                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-cloud" aria-hidden="true"></i>&nbsp;Save</button>
                                    @endcan
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

