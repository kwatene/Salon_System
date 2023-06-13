@extends('layout.customer_app')

@section('title')
    Customer Dashboard
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


        <section class="content">
            <div class="container-fluid">
                <h5>Your Bookings</h5>
                @if(isset($bookings) && $bookings != '' && $bookings != '[]')
                    <table id="dataTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Action</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Member</th>
                            <th>Services</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bookings as $key=>$booking)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    @if($booking->status == 0 )
                                        <a   class="btn btn-outline-danger " href="{{ route('customer-booking.cancel', $booking->id) }}"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        <a  class="btn btn-outline-primary " data-toggle="modal" data-target="#bookingModal-{{$booking->id}}" role="button"><i class="fa fa-cloud" aria-hidden="true"></i></a>
                                    @else
                                        No
                                    @endif
                                </td>
                                <td>{{$booking->date??'Not Found'}}</td>
                                <td>{{$booking->time??'Not Found'}}</td>
                                <td>{{ucwords($booking->user->name??'Not Found')}}</td>
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
                            <div class="modal fade" id="bookingModal-{{$booking->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Update Booking</h5>
                                            {{--                                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fas fa-close"></i></button>--}}
                                        </div>
                                        <div class="modal-body">
                                            <div class="row border" style=" border-radius: 10px;">
                                                <div class="overflow-hidden col-4 p-0" style="max-height: 200px; ">
                                                    <img class="" @if(is_file('upload/service/'.$booking->booking_cart->service->id.'/'.$booking->booking_cart->service->image->name) && isset($booking->booking_cart->service->image)) src="{{ asset('upload/service/'.$booking->booking_cart->service->id.'/'.$booking->booking_cart->service->image->name) }}" @else src="{{ asset('upload/img_not_found.png') }}" @endif alt="" style=" width: 100%; border-top-left-radius: 10px;   border-bottom-left-radius: 10px; ">
                                                </div>
                                                <div class="p-1 col-8">
                                                    <h3 >{{ ucwords($booking->booking_cart->service->name??'unknown' )}}</h3>
                                                    Time: {{($booking->booking_cart->service->minimum_hour??0). 'Hour & '. ($booking->booking_cart->service->minimum_minutes??00). ' Minutes'}}
                                                </div>
                                            </div>
                                            <div class="">
                                                <form action="{{ route('customer-booking.update') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="booking_id" value="{{ $booking->id??'' }}">
                                                    @if($booking->booking_cart->service->consent_form == 1)
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
                                                                        <option value="{{$user->id??''}}" @if($booking->user_id == $user->id) selected @endif> {{ucwords($user->name??'unknown')}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value=""> -No any Employee-</option>
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <div class="form-group mt-2 col-6">
                                                            <label for="date">Date</label>
                                                            <input required name="date" id="date" class="form-control" type="date" value="{{$booking->date??''}}"/>
                                                        </div>
                                                        <div class="form-group mt-2 col-6">
                                                            <label for="time">Time</label>
                                                            <input required name="time" id="time" class="form-control" type="time" value="{{$booking->time??''}}"/>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mb-2 col-12"> <i class="fas fa-bookmark"></i>&nbsp;Update</button>
                                                    <button type="button" class="btn btn-secondary col-12" data-dismiss="modal">Close</button>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
    </div>
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

