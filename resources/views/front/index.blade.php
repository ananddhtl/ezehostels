@extends('front.layouts.master')
@section('css')
<style>
#overlay {
  opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden
}

@media only screen and (min-width: 600px){
    #services-home-mobile{
        display: none;
    }
}

</style>
@endsection
@section('title')
Home
@endsection
@section('content')
@if(!empty($home_background))
<div class="main-content">
<section id="home-search-field" style="background: linear-gradient(0deg,rgba(255,0,0,0.7),rgba(255,0,0,0.7)),url('{{ asset("uploads"."/".$home_background[0]->image) }}'); background-size: cover; background-position: center;">
@else 
<section id="home-search-field" style="background: linear-gradient(0deg,rgba(255,0,0,0.7),rgba(255,0,0,0.7)); background-size: cover; background-position: center;">
@endif
    <div class="container-fluid">
        <div class="home-caption text-center">
            <h1 class="home-caption-text" style="color: white; font-weight: 700; font-size: 40px;">Nepal's Fastest and Reliable Hostel Search</h1>
        </div>
        <div class="home-form text-center">
        
        <form class="search-form" action="{{ URL::to('/eze-hostels/search') }}">

                <select id="city" name="city" class="city" required>
                    <option disabled selected>--- Select City ---</option>
                    @foreach($cities as $city) 
                    <option value="{{ $city->title }}">{{ $city->title }}</option>
                    @endforeach
                </select> 
                <select id="sub-city" name="place" class="place">
                    
                </select>
                <select id="room-type" name="room_type" required>
                    
                    <option value="single">Single</option>
                    <option value="shared(2)">Sharing(2)</option>
                    <option value="shared(3)">Sharing(3)</option>
                    <option value="shared(4)">Sharing(4)</option>
                    <option value="shared(5)">Sharing(5)</option>
                </select>
                <select id="hostel-type" name="type" required>          
                    <option value="boys">Boys Hostel</option>
                    <option value="girls">Girls Hostel</option>
                </select>
					<button class="search-button" type="submit">Search</button>
            </form>
            
        </div>
    </div>
</section>

<section id="services-home">
    <div class="container-fluid">
        @if($services)
        <div class="row">
            <div class="col-md-3" style="border-right: 1px solid white;;">
                <h2 class="services-home" style="font-weight: 800; color: white; margin: 0; padding-top: 12px;">Our Services</h2>
            </div>
            @foreach($services as $service)
            <div class="icon-box col-md-2">
                <div class="service-icon-box">
                    <div class="text-center">
                        <img class="service-icon" src="{{ asset('uploads/services'.'/'.$service->image) }}"/>
                    </div>
                    <h6 class="service-caption">{{ $service->title }}</h6>
                </div>
            </div>
            @endforeach
            
            <div class="col-md-1 text-center">
                <a href="{{ route('services') }}"><button class="service-view-more">View More ></button></a>
            </div>
        </div>
        @endif
    </div>
</section>
            
<section id="home-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                @if(!empty($offer_banner))
                @foreach($offer_banner as $b)
                <div class="banner_image">
                    <img class="banner-img" src="{{ asset('uploads'.'/'.$b->image) }}" alt="offer-banner">
                </div>
                @endforeach
                @endif
				@if($featured_hostels)
                <div class="featured">
                    <h2 class="div-title">Featured Hostels</h2>
                    
                    <div class="row">
                        @foreach($featured_hostels as $featured_hostel)
                        <div class="col-sm-4">
                            <div class="hostel-card">
                                <a href="{{URL::to('eze-hostels'.'/'.$featured_hostel->slug) }}">
                                   
									
									
									@php
                                        $fsingle_available = 0;
                                        $ftwo_available = 0;
                                        $fthree_available = 0;
                                        $ffour_available = 0;
                                        $ffive_available = 0;
                                    @endphp
                                    @if($featured_hostel->hostelprices->where('room_type','single')->count() > 0)
                                        @php
                                            $fsingle_available = $featured_hostel->hostelprices->where('room_type','single')->first()->available_room;
                                        @endphp
                                    @endif
                                    @if($featured_hostel->hostelprices->where('room_type','shared(2)')->count() > 0)
                                        @php
                                            $ftwo_available = $featured_hostel->hostelprices->where('room_type','shared(2)')->first()->available_room;
                                        @endphp
                                    @endif
                                    @if($featured_hostel->hostelprices->where('room_type','shared(3)')->count() > 0)
                                        @php
                                            $fthree_available = $featured_hostel->hostelprices->where('room_type','shared(3)')->first()->available_room;
                                        @endphp
                                    @endif
                                    @if($featured_hostel->hostelprices->where('room_type','shared(4)')->count() > 0)
                                        @php
                                            $ffour_available = $featured_hostel->hostelprices->where('room_type','shared(4)')->first()->available_room;
                                        @endphp
                                    @endif
                                    @if($featured_hostel->hostelprices->where('room_type','shared(5)')->count() > 0)
                                        @php
                                            $ffive_available = $featured_hostel->hostelprices->where('room_type','shared(5)')->first()->available_room;
                                        @endphp
                                    @endif
                                    
                                    @if($fsingle_available === 0 && $ftwo_available === 0 && $fthree_available === 0 && $ffour_available === 0 && $ffive_available === 0)
                                        <img class="hostel-card-img" src="{{ asset('uploads/hostels'.'/'.$featured_hostel->image) }}" style="opacity: 0.6" />
                                    @else
                                       <img class="hostel-card-img" src="{{ asset('uploads/hostels'.'/'.$featured_hostel->image) }}"/>
                                    @endif
									
									
                                    <div class="hostel-card-body">
                                        <h3 class="hostel-card-title">{{ $featured_hostel->title }}</h3>
                                        <p class="hostel-card-address">{{ $featured_hostel->place}}, {{ $featured_hostel->city }}</p>
                                        <span class="hostel-card-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </span>
                                        @php
                                            $f_p = '';
                                        @endphp
                                        
										
										<h4 class="hostel-card-price">NPR {{ $featured_hostel->price }}</h4>
                                        @php
                                            $fsingle_available = 0;
                                            $ftwo_available = 0;
                                            $fthree_available = 0;
                                            $ffour_available = 0;
                                            $ffive_available = 0;
                                        @endphp
										@if($featured_hostel->hostelprices->where('room_type','single')->count() > 0)
                                            @php
                                                $fsingle_available = $featured_hostel->hostelprices->where('room_type','single')->first()->available_room;
                                            @endphp
                                        @endif
                                        @if($featured_hostel->hostelprices->where('room_type','shared(2)')->count() > 0)
                                            @php
                                                $ftwo_available = $featured_hostel->hostelprices->where('room_type','shared(2)')->first()->available_room;
                                            @endphp
                                        @endif
                                        @if($featured_hostel->hostelprices->where('room_type','shared(3)')->count() > 0)
                                            @php
                                                $fthree_available = $featured_hostel->hostelprices->where('room_type','shared(3)')->first()->available_room;
                                            @endphp
                                        @endif
                                        @if($featured_hostel->hostelprices->where('room_type','shared(4)')->count() > 0)
                                            @php
                                                $ffour_available = $featured_hostel->hostelprices->where('room_type','shared(4)')->first()->available_room;
                                            @endphp
                                        @endif
                                        @if($featured_hostel->hostelprices->where('room_type','shared(5)')->count() > 0)
                                            @php
                                                $ffive_available = $featured_hostel->hostelprices->where('room_type','shared(5)')->first()->available_room;
                                            @endphp
                                        @endif
										
										@if($fsingle_available === 0 && $ftwo_available === 0 && $fthree_available === 0 && $ffour_available === 0 && $ffive_available === 0)
                                            <p class="hostel-card-rate">per month per person
                                                <span style="color:red; float:right; font-weight:800;">BOOKED OUT</span>
                                            </p>
                                        @else
                                           <p class="hostel-card-rate">per month per person</p>
                                        @endif
										

                                    </div>
                                </a>
                            </div>   
                        </div>
                        @endforeach
                        
                        
                    </div>
                </div>
				
                @endif
				
                @if($latest_hostels)
                <div class="trending">
                    <h2 class="div-title">Recent Hostels</h2>
                    <div class="row">
                        @foreach($latest_hostels as $latest_hostel)
                        @foreach($latest_hostel->hostelprices->where('room_type','single') as $price)
                        @php
                            $p = json_decode($price->pricing,true)['1 month'];
                        @endphp
                        @endforeach
						
						
						
                        <div class="col-sm-4">
                            <div class="hostel-card">
                            <a href="{{ URL::to('eze-hostels'.'/'.$latest_hostel->slug) }}">
								
								@php
                                    $lsingle_available = 0;
                                    $ltwo_available = 0;
                                    $lthree_available = 0;
                                    $lfour_available = 0;
                                    $lfive_available = 0;
                                @endphp
                                @if($latest_hostel->hostelprices->where('room_type','single')->count() > 0)
                                    @php
                                        $lsingle_available = $latest_hostel->hostelprices->where('room_type','single')->first()->available_room;
                                    @endphp
                                @endif
                                @if($latest_hostel->hostelprices->where('room_type','shared(2)')->count() > 0)
                                    @php
                                        $ltwo_available = $latest_hostel->hostelprices->where('room_type','shared(2)')->first()->available_room;
                                    @endphp
                                @endif
                                @if($latest_hostel->hostelprices->where('room_type','shared(3)')->count() > 0)
                                    @php
                                        $lthree_available = $latest_hostel->hostelprices->where('room_type','shared(3)')->first()->available_room;
                                    @endphp
                                @endif
                                @if($latest_hostel->hostelprices->where('room_type','shared(4)')->count() > 0)
                                    @php
                                        $lfour_available = $latest_hostel->hostelprices->where('room_type','shared(4)')->first()->available_room;
                                    @endphp
                                @endif
                                @if($latest_hostel->hostelprices->where('room_type','shared(5)')->count() > 0)
                                    @php
                                        $lfive_available = $latest_hostel->hostelprices->where('room_type','shared(5)')->first()->available_room;
                                    @endphp
                                @endif
                                
                                @if($lsingle_available === 0 && $ltwo_available === 0 && $lthree_available === 0 && $lfour_available === 0 && $lfive_available === 0)
                                    <img class="hostel-card-img" src="{{ asset('uploads/hostels'.'/'.$latest_hostel->image) }}" style="opacity: 0.6" />
                                @else
                                   <img class="hostel-card-img" src="{{ asset('uploads/hostels'.'/'.$latest_hostel->image) }}"/>
                                @endif
								
                                
                                <div class="hostel-card-body">
                                    <h3 class="hostel-card-title">{{ $latest_hostel->title }}</h3>
                                <p class="hostel-card-address">{{ $latest_hostel->place}}, {{ $latest_hostel->city }}</p>
                                    <span class="hostel-card-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </span>
                                    {{--@if(!empty($p))
                                    <h4 class="hostel-card-price">NPR {{ $p }}</h4>
                                    <p class="hostel-card-rate">per month per person</p>
                                    @endif--}}
									<h4 class="hostel-card-price">NPR {{ $latest_hostel->price }}</h4>
									
									
									@php
                                            $lsingle_available = 0;
                                            $ltwo_available = 0;
                                            $lthree_available = 0;
                                            $lfour_available = 0;
                                            $lfive_available = 0;
                                        @endphp
                                        @if($latest_hostel->hostelprices->where('room_type','single')->count() > 0)
                                            @php
                                                $lsingle_available = $latest_hostel->hostelprices->where('room_type','single')->first()->available_room;
                                            @endphp
                                        @endif
                                        @if($latest_hostel->hostelprices->where('room_type','shared(2)')->count() > 0)
                                            @php
                                                $ltwo_available = $latest_hostel->hostelprices->where('room_type','shared(2)')->first()->available_room;
                                            @endphp
                                        @endif
                                        @if($latest_hostel->hostelprices->where('room_type','shared(3)')->count() > 0)
                                            @php
                                                $lthree_available = $latest_hostel->hostelprices->where('room_type','shared(3)')->first()->available_room;
                                            @endphp
                                        @endif
                                        @if($latest_hostel->hostelprices->where('room_type','shared(4)')->count() > 0)
                                            @php
                                                $lfour_available = $latest_hostel->hostelprices->where('room_type','shared(4)')->first()->available_room;
                                            @endphp
                                        @endif
                                        @if($latest_hostel->hostelprices->where('room_type','shared(5)')->count() > 0)
                                            @php
                                                $lfive_available = $latest_hostel->hostelprices->where('room_type','shared(5)')->first()->available_room;
                                            @endphp
                                        @endif
                                        
                                        @if($lsingle_available === 0 && $ltwo_available === 0 && $lthree_available === 0 && $lfour_available === 0 && $lfive_available === 0)
                                            <p class="hostel-card-rate">per month per person
                                                <span style="color:red; float:right; font-weight:800;">BOOKED OUT</span>
                                            </p>
                                        @else
                                           <p class="hostel-card-rate">per month per person</p>
                                        @endif
									
                                </div>
                            </a>
                            </div>
                        </div>
                        @endforeach
                        
                        
                    </div>
                </div>
                @endif
                
                @if($blogs)
                <div class="recent-blogs">
                    <h2 class="div-title">Our Recent Blogs</h2>
                    <div class="row">
                        @foreach($blogs as $blog)
                        <div class="col-md-4">
                            <div class="blog-card" style="background-image: url({{ asset('uploads/blogs'.'/'.$blog->image)}})">
                                <div class="blog-card-text">
                                    <h5 class="blog-card-title">{{ $blog->title }}</h5>
                                </div>
                            </div>
                            <div class="blog-content">
                                <span class="blog-card-date">
                                    <i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($blog->date)->format('d M, Y') }}
                                </span>
								<p>{!! str_limit($blog->description,165) !!}</p>
								<a href="{{ URL::to('eze-hostels/blog'.'/'.$blog->slug) }}" class="blog-readmore">Read More</a>
                            </div>
                        </div>
                        @endforeach
                        
                    </div>
                </div>
                @endif
            </div>
            
            <div class="col-md-3">
                <div class="ads-sidebar">
                    @if($ads)
                    @foreach($ads as $ad)
                   <a href="{{$ad->ads_link}}" target="_blank"><img class="ads" src="{{ asset('uploads/siteads'.'/'.$ad->image) }}"/>
                  </a>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section> 
	
<div id="services-home-mobile">
    <div class="container-fluid">
        @if($services)
        <div class="row">
            <div class="col-md-3" style="border-right: 1px solid white;;">
                <h2 class="services-home" style="font-weight: 800; color: white; margin: 0; padding-top: 12px;">Our Services</h2>
            </div>
            @foreach($services as $service)
            <div class="icon-box col-md-2">
                <div class="service-icon-box">
                    <div class="text-center">
                        <img class="service-icon" src="{{ asset('uploads/services'.'/'.$service->image) }}"/>
                    </div>
                    <h6 class="service-caption">{{ $service->title }}</h6>
                </div>
            </div>
            @endforeach
            
            <div class="col-md-1 text-center">
                <a href="{{ route('services') }}"><button class="service-view-more">View More ></button></a>
            </div>
        </div>
        @endif
    </div>
</div>
</div>

@endsection
@section('js')
<script>
$(document).ready(function(){
    

    $("#sub-city").prop("disabled", true);
    $('#sub-city').prepend('<option  selected="selected">Loading cities...</option>');
    $('#city').on('change', function(){
        var id = $(this).val().toLowerCase();
        $('#sub-city').empty();
        $.get("{{URL::to('/getplacebycityid')}}"+ "/" + id, function(data){
            // console.log(data.result);
            if(data.status == "success"){
                if(data.result.length > 0){
                    $("#sub-city").prop("disabled", false);
                    $('#sub-city').prepend('<option selected disabled>--- Select Place ---</option>');
                    
                    $.each(data.result, function( key, value ) {
                        $('#sub-city').append($('<option>', { 
                                value: value.title,
                                text : value.title,
                        }));
                        
                    });
                }else{
                    $('#sub-city').prepend('<option>--- Select Place ---</option>');
                    $("#sub-city").prop("disabled", true);
                    // $('#catSubCatForm').submit();
                    
                }
            }
        });
    })
});
</script>
@endsection