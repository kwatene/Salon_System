@extends('layout.customer_app')

@section('title')
    Services
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
                        <h1>Services</h1>
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
                        @if(isset($services) && $services != '' && $services != '[]')
                            <div class="row">
                                @foreach($services as $service)
                                    <div class="col-md-4">
                                        <div class="card" style=" border-top-left-radius: 10px;   border-top-right-radius: 10px;">
                                            <div class="card-body p-0" style=" border-top-left-radius: 10px;   border-top-right-radius: 10px;">
                                                <div class="overflow-hidden" style="height: 200px;  border-top-left-radius: 10px;   border-top-right-radius: 10px;" role="button" data-toggle="modal" data-target="#detailModal-{{$service->id}}">
                                                    <img class="" @if(is_file('upload/service/'.$service->id.'/'.$service->image->name) && isset($service->image)) src="{{ asset('upload/service/'.$service->id.'/'.$service->image->name) }}" @else src="{{ asset('upload/img_not_found.png') }}" @endif alt="" style=" width: 100%; border-top-left-radius: 10px;   border-top-right-radius: 10px; ">
                                                </div>
                                                <div class="p-1">
                                                    <h3 class="text-center">{{ ucwords($service->name??'unknown' )}}</h3>
                                                    <p >Category: {{ ucwords($service->category->name??'-' )}}</p>
                                                    Time: <span class="badge rounded-pill bg-success"> {{($service->minimum_hour??0). 'Hour & '. ($service->minimum_minutes??00). ' Minutes'}}</span>
                                                </div>
                                                <div class="p-2">
                                                    <button type="button" class="btn btn-primary  col-12" data-toggle="modal" data-target="#bookingModal-{{$service->id}}">
                                                        <i class="fas fa-bookmark"></i>&nbsp;Book Now
                                                    </button>
                                                </div>
                                                <div class="modal fade" id="bookingModal-{{$service->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">New Booking</h5>
                                                                {{--                                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fas fa-close"></i></button>--}}
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row border" style=" border-radius: 10px;">
                                                                    <div class="overflow-hidden col-4 p-0" style="max-height: 200px; ">
                                                                        <img class="" @if(is_file('upload/service/'.$service->id.'/'.$service->image->name) && isset($service->image)) src="{{ asset('upload/service/'.$service->id.'/'.$service->image->name) }}" @else src="{{ asset('upload/img_not_found.png') }}" @endif alt="" style=" width: 100%; border-top-left-radius: 10px;   border-bottom-left-radius: 10px; ">
                                                                    </div>
                                                                    <div class="p-1 col-8">
                                                                        <h3 >{{ ucwords($service->name??'unknown' )}}</h3>
                                                                        <p >Category: {{ ucwords($service->category->name??'-' )}}</p>
                                                                        Time: {{($service->minimum_hour??0). 'Hour & '. ($service->minimum_minutes??00). ' Minutes'}}
                                                                    </div>
                                                                </div>
                                                                <div class="">
                                                                    <form action="{{ route('customer-booking.store') }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="service_id" value="{{ $service->id??'' }}">
                                                                        <input type="hidden" name="service_id" value="{{ $service->id??'' }}">
                                                                        @if($service->consent_form == 1)
                                                                        <h6 class="mt-3 text-danger"><b>Consent Form</b></h6>
                                                                        <div class="row border mt-1 border-danger">
                                                                            <div class="form-group mt-2 col-12">
                                                                                <label for="age">Your Age</label>
                                                                                <input required name="age" id="age" class="form-control" type="number" min="1" max="120" value="18"/>
                                                                            </div>
                                                                            <div class="form-group mt-2">
                                                                                <label for="allagic-yes" class="ml-2">Have a allagic:&nbsp;</label>
                                                                                <input name="allagic" id="allagic-yes"  type="radio" value="yes"/>
                                                                                <label for="allagic-yes" >Yes</label>
                                                                                <input name="allagic" id="allagic-no"  type="radio" value="no" checked/>
                                                                                <label for="allagic-no">No</label>

                                                                            </div>
                                                                            <hr/>
                                                                        </div>
                                                                        @endif
                                                                        <div class="row">
                                                                            <div class="form-group mt-2 col-12">
                                                                                <label for="user">Saloon Member</label>
                                                                                <select required name="user_id" id="user" class="form-control">
                                                                                    <option value="" selected> -Select Saloon Member-</option>
                                                                                    @if(isset($users) && $users != '' && $users != '[]')
                                                                                        @foreach($users as $user)
                                                                                            <option value="{{$user->id??''}}"> {{ucwords($user->name??'unknown')}}</option>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <option value=""> -No any Employee-</option>
                                                                                    @endif
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group mt-2 col-6">
                                                                                <label for="date">Date</label>
                                                                                <input required name="date" id="date" class="form-control" type="date"/>
                                                                            </div>
                                                                            <div class="form-group mt-2 col-6">
                                                                                <label for="time">Time</label>
                                                                                <input required name="time" id="time" class="form-control" type="time"/>
                                                                            </div>
                                                                        </div>
                                                                            <button type="submit" class="btn btn-primary mb-2 col-12"> <i class="fas fa-bookmark"></i>&nbsp;Book Now</button>
                                                                        <button type="button" class="btn btn-secondary col-12" data-dismiss="modal">Close</button>

                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="modal fade" id="detailModal-{{$service->id}}" tabindex="-1" aria-labelledby="examplDetailModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">{{ ucwords($service->name??'unknown' )}}&nbsp;<span class="badge rounded-pill bg-success"> {{($service->minimum_hour??0). 'Hour & '. ($service->minimum_minutes??00). ' Minutes'}}</span> | {{ ucwords($service->category->name??'-' )}} </h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row ">
                                                                    @if(isset($service->images))
                                                                    @foreach($service->images as $image)
                                                                        <div class="overflow-hidden shadow col-2 p-0 bg-light mr-1 rounded align-middle" style="height: 100px; ">
                                                                            <img class="rounded p-0" @if(is_file('upload/service/'.$service->id.'/'.$image->name) && isset($service->image)) src="{{ asset('upload/service/'.$service->id.'/'.$image->name) }}" @else src="{{ asset('upload/img_not_found.png') }}" @endif alt="" style=" width: 100%; ">
                                                                        </div>
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                                <hr/>
                                                                        <h6 class="mt-2">Description</h6>
                                                                        <p>{{ ucwords($service->note??'-' )}}</p>
                                                                <button type="button" class="btn btn-secondary col-12" data-dismiss="modal">Close</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            No any service providing yet
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- Button trigger modal -->
@endsection

@section('page-script')
    <script src="{{ asset('assets/sweetalert/sweetalert.all.min.js') }}"></script>
    <script>
        $('#date').on('change', function() {
            var periodError = false;
            var date = $(this).val();
                if(date < '{{$schedule->start_date}}'){
                    Swal.fire(
                        'Invalid Date?',
                        'pleas select valid date grater than '+ '{{$schedule->start_date}}',
                        'question',
                        {
                            confirmButtonText: 'Okay, understood',
                        }
                    );
                    $('#date').val('');
                    periodError = true;
                }else if(date > '{{$schedule->end_date}}') {
                    Swal.fire(
                        'Invalid Date?',
                        'pleas select valid date lower than ' + '{{$schedule->end_date}}',
                        'question',
                        {
                            confirmButtonText: 'Okay, understood',
                        }
                    );
                    $('#date').val('');
                    periodError = true;
                }
                if(!periodError){
                    const d = new Date(date);
                    const day = d.getDay();

                    if(day == 0 && ('{{$schedule->sunday}}' == 0) ){
                        Swal.fire(
                            'Unavailable Day?',
                            'We are not available in the sunday! Please book another day ',
                            'question',
                        );
                        $('#date').val('');
                    }

                    if(day == 1 && ('{{$schedule->monday}}' == 0) ){
                        Swal.fire(
                            'Unavailable Day?',
                            'We are not available in the monday! Please book another day ',
                            'question',
                        );
                        $('#date').val('');
                    }

                    if(day == 2 && ('{{$schedule->tuesday}}' == 0) ){
                        Swal.fire(
                            'Unavailable Day?',
                            'We are not available in the tuesday! Please book another day ',
                            'question',
                        );
                        $('#date').val('');
                    }
                    if(day == 3 && ('{{$schedule->wednesday}}' == 0) ){
                        Swal.fire(
                            'Unavailable Day?',
                            'We are not available in the wednesday! Please book another day ',
                            'question',
                        );
                        $('#date').val('');
                    }
                    if(day == 4 && ('{{$schedule->thursday}}' == 0) ){
                        Swal.fire(
                            'Unavailable Day?',
                            'We are not available in the thursday! Please book another day ',
                            'question',
                        );
                        $('#date').val('');
                    }
                    if(day == 5 && ('{{$schedule->friday}}' == 0) ){
                        Swal.fire(
                            'Unavailable Day?',
                            'We are not available in the friday! Please book another day ',
                            'question',
                        );
                        $('#date').val('');
                    }
                    if(day == 6 && ('{{$schedule->saturday}}' == 0) ){
                        Swal.fire(
                            'Unavailable Day?',
                            'We are not available in the saturday! Please book another day ',
                            'question',
                        );
                        $('#date').val('');
                    }

                }


        });
        $('#time').on('change', function() {
            var time = $(this).val();
                if(time < '{{$schedule->open_time}}'){
                    Swal.fire(
                        'Invalid Time?',
                        'pleas select valid time grater than '+ '{{$schedule->open_time}}',
                        'question',
                    );
                    $('#time').val('');
                }else if(time > '{{$schedule->close_time}}'){
                    Swal.fire(
                        'Invalid Time?',
                        'pleas select valid time lower than '+ '{{$schedule->close_time}}',
                        'question',
                    );
                    $('#time').val('');
                }




        });
        $('#age').on('change', function() {
            var age = $(this).val();
                if(age < 18){
                    Swal.fire(
                        'Age Restriction?',
                        'You have not permission to book this product',
                        'question',
                    );
                }


        });

    </script>
    @if(session()->has('booking_success'))
        <script>
            Swal.fire(
                'Good job!',
                'Your booking placed successfully!',
                'success'
            )
        </script>
    @endif
    @if(session()->has('booking_fail'))
        <script>
            Swal.fire(
                'Sorry!',
                'Failed to place your booking!',
                'error'
            )
        </script>
    @endif
@endsection

