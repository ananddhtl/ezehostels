<div class="listing-section">
    @if($hostels->count() > 0)
    @foreach($hostels as $hostel)
    <div class="hostel-masonry-card">

        <div class="row">

            <div class="col-md-6">

                <div class="owl-carousel owl-theme list-hostel">

                    @foreach($hostel->hostelgallery as $gallery)

                    <div class="item">

                        <a href="{{ URL::to('eze-hostels'.'/'.$hostel->slug) }}">

                            <img src="{{ asset('uploads/hostelgallery'.'/'.$gallery->image) }}" />

                        </a>

                    </div>

                    @endforeach 

                </div>

            </div>

            <div class="col-md-6">

                <h3 style="font-weight: 700; margin-bottom: 0; font-size: 1.25rem;">

                    {{ $hostel->title }}

                </h3>

                <span class="hostel-masonry-address">

                    {{ $hostel->place }}, {{ $hostel->city }}

                </span>

                <div class="masonry-rating">

                    <span class="hostel-card-rating">

                        <i class="fa fa-star"></i>

                        <i class="fa fa-star"></i>

                        <i class="fa fa-star"></i>

                        <i class="fa fa-star"></i>

                        <i class="fa fa-star"></i>

                    </span>

                </div>

                <div class="type">

                    <span class="masonry-type">Type: <b>{{ ucfirst(trans($hostel->type)) }} Hostel</b></span>

                </div>

                

                @if($hostel->hostelservices->count() > 0)

                    <div class="hostel-masonry-service">

                        @foreach($hostel->hostelservices as $service)

                        <span class="masonry-service">{{ $service->service }},</span>

                        @endforeach

                        {{-- <span class="masonry-service">+ view more</span> --}}

                    </div>

                @endif

                <hr style="margin: 3px 0;">

                @if(!empty($price))

                <span class="masonry-room-type">{{ ucfirst(trans($room_type)) }}</span>

                @endif

                <div class="row">

                    

                    <div class="col-sm-6">

                        <div class="masonry-best-price">

                        

                         

                         <div class="masonry-price">NPR {{ $hostel->price }}</div>

                             <div class="hostel-card-rate">per month per person</div>

                         </div>

                         

                    </div>

                    <div class="col-sm-6">

                        <div class="text-right">
                           
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
                                <p class="hostel-card-rate">
                                    <span style="color:red; float:right; font-weight:800;">BOOKED OUT</span>
                                </p>
                            @else
                               <button class="go-book">
                                <a href="{{ URL::to('eze-hostels'.'/'.$hostel->slug) }}">Go to Booking</a>
                                </button>
                            @endif

                            

                        </div>

                    </div>

                </div>

                

            </div>

        </div>

    </div>

    <hr>

    @endforeach

    

    {!! $pagination !!}

    
    @else	

    <div class="hostel-masonry-card text-center">

        <h4>Search Item Not Found</h4>

    </div>

    @endif				

    

</div>