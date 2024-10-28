@extends('front.layouts.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/owl.carousel.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/owl.theme.default.min.css') }}"/>
<style>
    .invalid-feedback{
        color:red;
        display:block;
    }
</style>
@endsection
@section('title')
{{ str_replace("-", ' ', ucfirst(trans($page_title))) }}
@endsection
@section('content')
<div class="main-content">
@if($hostel->hostelgallery->count() > 0)
<section class="hotel-slider-gallery">
    <div class="owl-carousel owl-theme">
        @foreach($hostel->hostelgallery as $gallery)
        <div class="item">
            <img src="{{ asset('uploads/hostelgallery'.'/'.$gallery->image) }}" />
        </div>
        @endforeach
        
    </div>
</section>
@endif
<section id="single-hostel-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="hostel-intro">
                    <h1 class="hostel-title">{{ $hostel->title }}</h1>
                    <span class="hostel-card-rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </span>
                    <p class="booking-hostel-address" style="margin: 0;">{{ $hostel->place}}, {{ $hostel->city }}</p>
                </div>
                <div class="hostel-desc" id="summary">
                    <h4>Description</h4>
                    <p class="collapse text-justify" id="collapseSummary1">{!! $hostel->description !!}</p>
                    <a class="collapsed" data-toggle="collapse" href="#collapseSummary1" aria-expanded="false" aria-controls="collapseSummary1"></a>
                </div>
                <div class="price-rate">
                    <h4>Pricings</h4>
                    <table class="price-table">
                            
                        <tr>
                            <th>Room Type</th>
                            <th>1 Month (NPR)</th>
                            <th>3 Months (NPR)</th>
                            <th>6 Months (NPR)</th>
                            <th>1 Year (NPR)</th>
                        </tr>
                        
                        @if(!empty($hostel->hostelprices->where('room_type','single')))
                        <tr>
                            <th>Single</th>
                            @foreach($hostel->hostelprices->where('room_type','single')->unique('single') as $p)
                            @foreach (json_decode($p->pricing) as $key => $value)
                            <td>{{ $value }}</td>
                            @endforeach
                            @endforeach
                        </tr>
                        @endif
                        @if(!empty($hostel->hostelprices->where('room_type','shared(2)')))
                        <tr>
                            <th>Shared(2)</th>
                            @foreach($hostel->hostelprices->where('room_type','shared(2)')->unique('shared(2)') as $p)
                            @foreach (json_decode($p->pricing) as $key => $value)
                            <td>{{ $value }}</td>
                            @endforeach
                            @endforeach
                        </tr>
                        @endif
                        @if(!empty($hostel->hostelprices->where('room_type','shared(3)')))
                        <tr>
                            <th>Shared(3)</th>
                            @foreach($hostel->hostelprices->where('room_type','shared(3)')->unique('shared(3)') as $p)
                            @foreach (json_decode($p->pricing) as $key => $value)
                            <td>{{ $value }}</td>
                            @endforeach
                            @endforeach
                        </tr>
                        @endif
                        @if(!empty($hostel->hostelprices->where('room_type','shared(4)')))
                        <tr>
                            <th>Shared(4)</th>
                            @foreach($hostel->hostelprices->where('room_type','shared(4)')->unique('shared(4)') as $p)
                            @foreach (json_decode($p->pricing) as $key => $value)
                            <td>{{ $value }}</td>
                            @endforeach
                            @endforeach
                        </tr>
                        @endif
                        @if(!empty($hostel->hostelprices->where('room_type','shared(5)')))
                        <tr>
                            <th>Shared(5)</th>
                            @foreach($hostel->hostelprices->where('room_type','shared(5)')->unique('shared(5)') as $p)
                            @foreach (json_decode($p->pricing) as $key => $value)
                            <td>{{ $value }}</td>
                            @endforeach
                            @endforeach
                        </tr>
                        @endif
                    </table>
                </div>
				@if($hostel->hostelprices->count() >0)
                <div class="price-rate">
                    <h4>Rooms Available</h4>
                    <table class="price-table">
                        
                        <tr>
                            @foreach($hostel->hostelprices->unique() as $p)
                            <th>{{ $p->room_type }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($hostel->hostelprices->unique() as $p)
                            <td>{{ $p->available_room }}</td>
                            @endforeach
                        </tr>		
                    </table>
                </div>
                @endif
                @if(!empty($services))
                <div class="hostel-services">
                    <h4>Services(Facilities)</h4>
                    <div class="hostel-service-list">
                        <div class="row">
                            @foreach($services as $service)
                                @foreach ($service as $s)
                                <div class="col-md-4">
                                    <span><img class="service-icon" src="{{ asset('uploads/services'.'/'.$s->image) }}"/></span>
                                    <span class="service-name">{{ $s->title }}</span>
                                </div>
                                @endforeach
                            @endforeach 
                        </div>
                        
                    </div>
                </div>
                @endif
                <div class="hostel-policies">
                    <h4>Hostel Policies</h4>
                    {!! $hostel->policies !!}
                </div>
                <div class="hostel-location">
                    <h4>Hostel's Location</h4>
                    <div class="row">
                        {!! $hostel->iframe !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="booking">
                    <div class="booking-hostel-title">
                        {{ $hostel->title }}
                    </div>
                    <div class="booking-hostel-address">{{ $hostel->place }}, {{ $hostel->city }}</div>
                    <hr style="border-top: 1px dashed gray; margin-top: 10px;">
                    <div class="book-hostel-type">
                        <h6 style="margin: 0;">Type: <b>{{ ucfirst(trans($hostel->type)) }} Hostel</b></h6>
                    </div>
                    <form method="GET" action="{{ route('booking') }}">
                        <input type="hidden" name="hostel_name" value="{{ $hostel->title }}">
                        <input type="hidden" name="place" value="{{ $hostel->place }}">
                        <input type="hidden" name="city" value="{{ $hostel->city }}">
                        <input type="hidden" name="type" value="{{ $hostel->type }}">
                        <div class="book-stay-length">
                            <select id="length-of-stay" name="length_of_stay">
                                <option disabled selected>-- Length of Stay --</option>
                                <option value="1 month">1 Month</option>
                                <option value="3 months">3 Months</option>
                                <option value="6 months">6 Months</option>
                                <option value="1 year">1 Year</option>
                                <option value="2 years">2 Years</option>
                                <option value="3 years">3 Years</option>
                                <option value="4 years">4 Years</option>
                                <option value="5 years">5 Years</option>
                            </select>
                            @error('length_of_stay')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="room-type">
                            <select id="book-room-type" name="room_type">
                                <option disabled selected>-- Select Room Type --</option>
                                <option value="single">Single</option>
                                <option value="sharing(2)">Sharing(2)</option>
                                <option value="sharing(3)">Sharing(3)</option>
                                <option value="sharing(4)">Sharing(4)</option>
                                <option value="sharing(5)">Sharing(5)</option>
                            </select>
                            @error('room_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="no-of-people">
                            <select id="no-of-people" name="no_of_people">
                                <option disabled selected>-- No. of People --</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="1">3</option>
                                <option value="2">4</option>
                                <option value="1">5</option>
                                <option value="2">6</option>
                                <option value="1">7</option>
                                <option value="2">8</option>
                                <option value="1">9</option>
                                <option value="2">10</option>
                            </select>
                            @error('no_of_people')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @php
                            $single_available = 0;
                            $two_available = 0;
                            $three_available = 0;
                            $four_available = 0;
                            $five_available = 0;
                        @endphp
                        @if($hostel->hostelprices->where('room_type','single')->count() > 0)
                            @php
                                $single_available = $hostel->hostelprices->where('room_type','single')->first()->available_room;
                            @endphp
                        @endif
                        @if($hostel->hostelprices->where('room_type','shared(2)')->count() > 0)
                            @php
                                $two_available = $hostel->hostelprices->where('room_type','shared(2)')->first()->available_room;
                            @endphp
                        @endif
                        @if($hostel->hostelprices->where('room_type','shared(3)')->count() > 0)
                            @php
                                $three_available = $hostel->hostelprices->where('room_type','shared(3)')->first()->available_room;
                            @endphp
                        @endif
                        @if($hostel->hostelprices->where('room_type','shared(4)')->count() > 0)
                            @php
                                $four_available = $hostel->hostelprices->where('room_type','shared(4)')->first()->available_room;
                            @endphp
                        @endif
                        @if($hostel->hostelprices->where('room_type','shared(5)')->count() > 0)
                            @php
                                $five_available = $hostel->hostelprices->where('room_type','shared(5)')->first()->available_room;
                            @endphp
                        @endif
                        
                        @if($single_available === 0 && $two_available === 0 && $three_available === 0 && $four_available === 0 && $five_available === 0)
                           <div class="book-now">
                            <p class="go-book " disabled="disabled" style="color:red;background: none; font-weight: 900; text-align: center;">
                                BOOK OUT
                            </p>
                        </div>
                        @else
                           <button class="continue-book-btn" type="submit">Continue to Book</button>
                        @endif
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@if($near_hostels->count() > 0)
<section id="nearby-hostels">
        <div class="container-fluid">
            <h3 class="nearby-title">Nearby Hostels</h3>
            <hr style="margin: 12px 0; border-top: 1px solid red;">
            <div class="row">
                @foreach($near_hostels as $near_hostel)
                <div class="col-md-3">
                    <div class="hostel-card">
                        <a href="{{ URL::to('eze-hostels'.'/'.$near_hostel->slug) }}">
                            <img class="hostel-card-img" src="{{ asset('uploads/hostels'.'/'.$near_hostel->image) }}"/>
                            <div class="hostel-card-body">
                            <h5 class="hostel-card-title">{{ $near_hostel->title }}</h5>
                            <p class="hostel-card-address">{{ $near_hostel->place }}, {{ $near_hostel->city }}</p>
                            <span class="hostel-card-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </span>
                            
                           
                            <h4 class="hostel-card-price">NPR {{ $near_hostel->price }}</h4>
                            <p class="hostel-card-rate">per month per person</p>
                            
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
</section>
</div>
@endif
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('assets/front/js/owl.carousel.js') }}"></script>

<script type="text/javascript">
    $('.owl-carousel').owlCarousel({
        stagePadding: 50,
        loop:true,
        margin:2,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        nav:true,
        navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:2
            }
        }
    })
    
</script>
@endsection