@extends('front.layouts.master')
@section('css')
<style>
.error{
    color:red;
}
</style>
@endsection
@section('content')
<div class="main-content">
    <section id="booking-page">
        <div class="container-fluid">
            <div class="go-back">
                <a href="{{ url()->previous() }}" style="color: red; font-weight: 700;"><i class="fa fa-chevron-left"></i> Go Back</a>
            </div>
            <div class="row">
                <div class="col-md-8 form-body">
                    <div class="form-header"><h4 style="margin: 0;">Enter Your Details</h4></div>
                    <form name="bookForm" id="bookForm">
                    @csrf
                        <input type="hidden" name="hostel_name" value="{{ $data['hostel_name'] }}">
                        <input type="hidden" name="place" value="{{ $data['place'] }}">
                        <input type="hidden" name="city" value="{{ $data['city'] }}">
                        <input type="hidden" name="type" value="{{ $data['type'] }}">
                        <input type="hidden" name="length_of_stay" value="{{ $data['length_of_stay'] }}">
                        <input type="hidden" name="room_type" value="{{ $data['room_type'] }}">
                        <input type="hidden" name="no_of_people" value="{{ $data['no_of_people'] }}">
                        
                        <div class="row"  style="margin: 10px 0;">
                            <div class="col-sm-6">
                                <div class="form-label">Full Name*</div>
                                <input type="text" name="name" data-msg="Name shouldn't be empty">
                            </div>
                            <div class="col-sm-6">
                                <div class="form-label">Mobile Number*</div>
                                <input type="text" name="phone" data-rule-minlength="10" data-rule-maxlength="10"  data-msg-minlength="Phone number should be 10 digit" data-msg-minlength="Phone number should be 10 digit" data-msg="Phone number shouldn't be empty">
                            </div>
                        </div>
                        <div class="row" style="margin: 10px 0;">
                            <div class="col-sm-6" style="margin: 10px 0;">
                                <div class="form-label">Email*</div>
                                <input type="text" name="email" data-msg-email="Please provide a valid email address" data-msg="Email shouldn't be empty">
                            </div>
                            <div class="col-sm-6" style="margin: 10px 0;">
                                <div class="form-label">Address</div>
                                <input type="text" name="address">
                            </div>
                        </div>
                        <button class="book-now-btn book">Book Now</button>
                    </form>
                </div>
                
                <div class="col-md-4">
                    <div class="booking-2nd">
                        <div class="booking-hostel-title">
                            {{ $data['hostel_name'] }}
                        </div>
                        <p class="booking-hostel-address" style="margin: 0;">{{ $data['place']}}, {{ $data['city']}}</p>
                        <div class="book-hostel-type">
                            <p style="margin: 0;">Type: <b>{{ ucfirst(trans($data['type'])) }} Hostel</b></p>
                        </div>
                        <div class="booking-stay-length">
                            <p style="margin: 0;">Length of Stay: <b>{{ $data['length_of_stay'] }}</b></p>
                        </div>
                        <div class="booking-room-type">
                            <p style="margin: 0;">Room Type: <b>{{ $data['room_type'] }}</b></p>
                        </div>
                        <div class="booking-no-of-people">
                        <p style="margin: 0;">No. of People: <b>{{ $data['no_of_people'] }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@section('js')
{{-- jquery validation --}}
<script src="{{ asset('assets/admin/js/jquery.validate.js') }}" type="text/javascript"></script>
{{-- sweat alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /* form validaion */
    var validator = $("#bookForm").validate({
        rules: {
            name: {
                required: true,
            },
            phone: {
                required: true,
               
            },
            email: {
                required: false,
                email:true
            }
        }
    });
    /* when book now button click */
     /* when save button click */
     $('.book').click(function(e){
        e.preventDefault();
        if($('#bookForm').valid()){
            var uri     = "{{ route('book') }}";
            var result  = new FormData($("#bookForm")[0]);
            $.ajax({
                data: result,
                url: uri,
                type: "POST",
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (data) {
                    if(data.status=='success'){
                        // based on store or update method showing alert information
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        Toast.fire({
                            type: 'success',
                            title: 'Booking Success. We will contact you soon !!'
                        });
                        setTimeout(function(){
                            window.location.href = "{{ route('home')}}"
                        }, 1000);
                    }
                    else{
                        swal('Not allowed!!','error');
                    }
                },
                error: function (data) {
                    swal('Somethings error');
                }
            });
        }
     });
});
</script>
@endsection