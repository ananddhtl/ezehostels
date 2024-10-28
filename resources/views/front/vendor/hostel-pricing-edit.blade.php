@extends('front.layouts.master')
@section('title')
User Dashboard
@endsection
@section('css')

<style>

.invalid-feedback{

    color:red;

    display: block;

}

.success-feedback{

    color:blue;

    display: block;

}

#city, #sub-city, #room-type, #hostel-type {

    border: 1px solid lightgray;

    padding: 0;

    margin: 0;

    font-weight: 500;

}

i.form-control.text-center.add_more {

    background-color: #020afb;

    color: black;

    

    cursor: pointer;

}

i.form-control.text-center.minus_more {

    background-color: red;

    color: black;

    

    cursor: pointer;

}

a.btn-primary.btn-sm{

    text-decoration: none;

}

.btn-primary {

    color: #fff;

    background-color: #ff0000;

    border-color: #060606;

}

</style>

@endsection

@section('content')

<div class="container-fluid">

        <div class="row">

            <div class="col-md-12">

                <h3>Pricing and Seats Availability

                    <a href="{{ URL::to('/easy-hostels/vendor'.'/'.auth::user()->id. '/'. 'hostels-pricing') }}" class="btn-primary btn-sm viewall">view all pricing</a>

                </h3>

                <hr style="margin: 10px 0;">

                <div class="pricing-rate">

                    <form method="POST" action="{{ route('vendorhostelpricingupdate',$pricing->id) }}">

                        @csrf

                        <input type="hidden" class="hostel-price-id"  value="">

                        <div class="form-group row">

                            <div class="col-md-4">

                                @php

                                    $hostels = DB::table('hostels')->where('vendor_id',auth::user()->id)->get();

                                @endphp

                                <label><b>Hostel</b></label>

                                <select name="hostel" class="form-control hostel"  id="hostels">

                                    <option disabled="disabled" selected="selected">Please select hostel</option>

                                    @foreach($hostels as $hostel)

                                    <option {{ $pricing->hostel_id == $hostel->id ? 'selected' : '' }} value="{{ $hostel->id }}">{{ $hostel->title }}</option>

                                    @endforeach

                                </select>

                                @error('hostel')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                            <div class="col-md-4">

                                <label><b>Room Type</b></label>

                                <select name="room_type" class="form-control room_type" data-msg="Please select room type ">

                                    <option selected disabled>Select room type </option>

                                    <option {{ $pricing->room_type == 'single' ? 'selected' : '' }} value="single">single</option>

                                    <option {{ $pricing->room_type == 'shared(2)' ? 'selected' : '' }} value="shared(2)">shared(2)</option>

                                    <option {{ $pricing->room_type == 'shared(3)' ? 'selected' : '' }} value="shared(3)">shared(3)</option>

                                    <option {{ $pricing->room_type == 'shared(4)' ? 'selected' : '' }} value="shared(4)">shared(4)</option>

                                    <option {{ $pricing->room_type == 'shared(5)' ? 'selected' : '' }} value="shared(5)">shared(5)</option>

                                </select>

                                @error('room_type')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                            <div class="col-md-4">

                                <label><b>Available Room</b></label>

                            <input type="number" name="available_room" class="form-control available_room" value="{{ $pricing->available_room }}">

                            </div>

                            

                        </div>

                        <div class="form-group main-div">

                            @foreach(json_decode($pricing->pricing) as $key =>$p)

                            <div class="row">

                                <div class="col-md-4">

                                    <label><b>Pricing Type</b></label>

                                    <select name="pricing[]" class="form-control pricing" data-msg="Please select pricing type " >

                                        <option selected disabled>Select pricing type </option>

                                        <option {{ $key == '1 month' ? 'selected' : '' }} value="1 month">1 month</option>

                                        <option {{ $key == '3 months' ? 'selected' : '' }} value="3 months">3 months</option>

                                        <option {{ $key == '6 months' ? 'selected' : '' }} value="6 months">6 months</option>

                                        <option {{ $key == '1 years' ? 'selected' : '' }} value="1 years">1 years</option>

                                    </select>

                                </div>

                                <div class="col-md-4">

                                    <label><b>Price</b></label>

                                <input type="number" name="price[]" class="form-control price"  placeholder="Price" value="{{ $p }}">

                                </div>

                                <div class="col-md-4">

                                    <div class="pricing_add_more">

                                        <label><b>add more</b></label><br><i class="form-control text-center add_more">add more</i>

                                    </div>

                                </div>

                            </div>

                            @endforeach

                        </div>

                        @error('pricing')

                        <span class="invalid-feedback" role="alert">

                            <strong>{{ $message }}</strong>

                        </span>

                        @enderror

                        @error('price')

                        <span class="invalid-feedback" role="alert">

                            <strong>{{ $message }}</strong>

                        </span>

                        @enderror

                        

                        <div class="update">

                            <button class="update-btn">Save Changes</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

</div>

@endsection

@section('js')

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>

$(document).ready(function(){

    

    // /* add more field for hostel pricing */

    // $(".main-div").append('<div class="row"><div class="col-md-4"><label><b>Pricing Type</b></label><select name="pricing[]" class="form-control pricing" data-msg="Please select pricing type " ><option selected disabled>Select pricing type </option><option value="1 month">1 month</option><option value="3 months">3 months</option><option value="6 months">6 months</option><option value="1 years">1 years</option></select></div><div class="col-md-4"><label><b>Price</b></label><input type="number" name="price[]" class="form-control price"  placeholder="Price" ></div><div class="col-md-4"><div class="pricing_add_more"><label><b>add more</b></label><br><i class="form-control text-center add_more">add more</i></div></div></div>')



    /* while add more button click */

    

    $(document).on('click',".add_more",function(e){

        e.preventDefault()

        $(".main-div").append('<div class="row"><div class="col-md-4"><label><b>Pricing Type</b></label><select name="pricing[]" class="form-control pricing" data-msg="Please select pricing type " ><option selected disabled>Select pricing type </option><option value="1 month">1 month</option><option value="3 months">3 months</option><option value="6 months">6 months</option><option value="1 years">1 years</option></select></div><div class="col-md-4"><label><b>Price</b></label><input type="number" name="price[]" class="form-control price"  placeholder="Price" ></div><div class="col-md-4"><div class="pricing_add_more"><label><b>Remove</b></label><br><i class="form-control text-center minus_more">remove</i></div></div></div>')

    });

    $(".main-div").on("click",".minus_more", function(e){ 

        e.preventDefault();

		$(this).parent('div').parent('div').parent('div').remove(); //remove input field

		

    })

})

</script>

@endsection