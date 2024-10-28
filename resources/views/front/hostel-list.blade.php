@extends('front.layouts.master')
@section('meta_tag')
@if(!empty($description))
<meta name="description" content="{!! $description->description !!}">
@endif
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/price_range_style.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/jquery-ui.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/owl.carousel.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/owl.theme.default.min.css') }}"/>
<style>
b.type {
    text-transform: capitalize;
}

</style>
@endsection

@section('title')
@if(!empty($meta_key))
{{ $meta_key->meta_key }}
@else
EZE Hostels Search
@endif
@endsection
@section('content')
<div class="main-content">
<section id="hostel-listing">
    <div class="container-fluid">
        <div class="row pt-2">
                        <div class="col-6 col-md-3">
                            <a href="#">
                                <img class="ad-img" src="https://ezehostels.com/uploads/siteads/1575558688.gif">
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="#">
                                <img class="ad-img" src="https://ezehostels.com/uploads/siteads/1580990263.gif">
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="#">
                                <img class="ad-img" src="https://ezehostels.com/uploads/siteads/1580990289.gif">
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="#">
                                <img class="ad-img" src="https://ezehostels.com/uploads/siteads/1575606265.gif">
                            </a>
                        </div>
                    </div>
        <div class="row">
            <div class="col-md-3 order-sm-1 order-2 filter">
                <div class="filter-section">
                    <h6 class="filter-sidebar-title">Filter by Location</h6>
                    <hr style="margin: 8px 0;">
                    <div class="location-filter">
                        <form>
                           
                            <select id="city-filter">
                                @foreach($cities as $city)
                                <option value="{{ $city->title }}" @if(\Request::get("city") != "" && ($city->title == \Request::get('city'))){{'selected'}}@endif>{{ ucfirst(trans($city->title)) }}</option>
                                @endforeach
                                
                            </select>
                            
                            <select id="sub-city-filter">
                                @if(\Request::get('place') != "")
                                    <option value="{{\Request::get('place')}}" selected="" disabled="">{{\Request::get('place')}}</option>
                                @endif
                            </select>
                        </form>
                    </div>
                    
                    <div class="type-filter">
                        <h6 class="filter-sidebar-title">Filter by Type</h6>
                        <hr style="margin: 8px 0;">
                        <form>
                            
                            <div class="">
                                <input id="checkboys" class="type" type="checkbox" name="type" value="boys" @if(\Request::get('type') && (\Request::get('type') == "boys")){{'checked'}}@endif >
                                <label for="boys">Boys Hostel</label>
                                <span></span>
                            </div>
                            <div class="">
                                <input id="checkgirls" class="type" type="checkbox" name="type" value="girls" @if(\Request::get('girls') && (\Request::get('type') == "girls")){{'checked'}}@endif>
                                <label for="girls">Girls Hostel</label>
                                <span></span>
                            </div>
                        </form>
                    </div>
                    
                    <div class="price-filter">
                        <h6 class="filter-sidebar-title">Filter by Price Range</h6>
                        <hr style="margin: 8px 0;">
                        <form class="price-range">
                                
                            @csrf
                            <div id="slider-range" class="price-filter-range" name="rangeInput"></div>
                            <input type="number" min="5000" max="19999"  id="min_price" class="price-range-field" step="500" value="5000" name="min_value" />
                            <input type="number" min="5000" max="20000"  id="max_price" class="price-range-field" step="500" value="20000" name="max_value" />
                        </form>
                    </div>
                    
                    <div class="service-filter">
                        <h6 class="filter-sidebar-title">Filter by Facilities(Services)</h6>
                        <hr style="margin: 8px 0;">
                        <form>
                        
                        @foreach($services as $service)
                        <div class="">
                            <input type="checkbox" class="services" name="service[]" value="{{ $service->title }}">
                            <label for="checkWifi">{{ $service->title }}</label>
                            <span></span>
                        </div>
                        @endforeach
                        </form>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-9 col-sm-12 order-1">
                <div class="listing-section">
                    <h5 class="eze-count">({{ $total_records }} EZEs Found )</h5>
                    <div class="sort text-right">
                        <form>
                            <span class="sorting">
                            Sort By
                                <select class="sort-filter" name="sort">
                                    <option value="low_to_high">Price Low to High</option>
                                    <option value="high_to_low">Price High to Low</option>
                                </select>
                            </span>
                        </form>								
                    </div>
                    <div id="append-div">
                        @include('front.pagination')
                    </div>
                    @if(!empty($meta_description))
                    <p>{!! $meta_description->search_result_description !!}</p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</section>


@endsection
@section('js')

<script type="text/javascript" src="{{ asset('assets/front/js/jquery.ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/front/js/price_range_script.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/front/js/owl.carousel.js') }}"></script>

<script>
init_carousel();
$(window).on('hashchange', function() {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        }else{
            getData(page);
            
        }
    }
});
$(document).ready(function(){
    /* ajax set up */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    
    
   
    $(document).on('click', '.pagination a',function(event){
        event.preventDefault();
        //need to call the function
        var current_page =$(this).attr('href');
        current_page     = current_page.slice(1);
        renderSearchParameters(current_page);
    
    });
  
    var services = [];
    /* hostel filter by city */
    $("#sub-city-filter").prop("disabled", true);
    $('#city-filter').on('change', function(){
        var city = $("#city-filter").val();
        /* checking if city has places or not */
        $('#sub-city-filter').empty();
        $.get("{{ URL::to('/getplacebycityid') }}"+ "/" + city, function(data){
            // console.log(data.result);
            if(data.status == "success"){
                if(data.result.length > 0){
                    $("#sub-city-filter").prop("disabled", false);
                    
                    $.each(data.result, function( key, value ) {
                        $('#sub-city-filter').append($('<option>', { 
                                value: value.title,
                                text : value.title,
                        }));
                    });
                    renderSearchParameters();
                }else{
                    
                    $("#sub-city-filter").prop("disabled", true);
                    // $('#catSubCatForm').submit();
                }
            }
        });
    });
   

    /* hostel filter by place */
    $('#sub-city-filter').on('change', function(){
        renderSearchParameters();
    });
    
    /* hostel filter by hostel type */
    $('.type').click(function() {
        $('.type').not(this).prop('checked', false);
        renderSearchParameters();
    });
    /* hostel filter by services */
    $('.services').click(function () {
         renderSearchParameters();
    });
    /* sort by price */
    $('.sort-filter').on('change', function() {
        renderSearchParameters();
    });
    
    /* slider range setup */
    $("#slider-range").slider({
        range: true,
        orientation: "horizontal",
        min: 0,
        max: 10000,
        values: [$("#min_price").val(), $("#max_price").val()],
        step: 100,

        slide: function (event, ui) {
            if (ui.values[0] == ui.values[1]) {
                return false;
            }
            $("#min_price").val(ui.values[0]);
            $("#max_price").val(ui.values[1]);            
        },
        stop: function(event, ui){
            renderSearchParameters();           
        }
    });
});

function init_carousel(){
    $('.owl-carousel').owlCarousel({
        loop:true,
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
                items:1
            }
        }
    }).trigger('refresh.owl.carousel');
}


//added on 01/01/2020 by manoj
function renderSearchParameters($current_page=1){
    //render the search paramaters from the dom
     var search_data      = {};
     var city             = $("#city-filter").val();
     var place            = $("#sub-city-filter").val();
     var hostel_name      = $("input[name='hostel_name']").val();
     var sort             = $(".sort-filter").val();
     var min_price        = $("#min_price").val();
     var max_price        = $("#max_price").val();
     var hostel_type      = $('input[name="type"]:checked').val();
     var services         = $("input[name='service[]']");
     var checked_services = [];
     $.each(services,function(index,value){
        if(this.checked){
            checked_services.push(value.value);
        }
     });

     
    //check for the not empty value and insert in the array if they are not empty

     //check for the city empty value
     if(typeof(city) != "undefined" && city !== null){
        search_data['city'] = city;
        
     }

     //check for the place empty value
     if(typeof(place) != "undefined" && place !== null){
       search_data['place'] = place;
       
    }
    //check for the hostel name empty value
    if(typeof(hostel_name) != "undefined" && hostel_name !== null && hostel_name != ""){
        search_data['hostel_name'] = hostel_name;
    }
    // check for the sort by price epmty value
    if(typeof(sort) != "undefined" && sort !== null && sort != ""){
        search_data['sort'] = sort;
    }

    //check for the price filter range slider min and max value
    if((typeof(min_price) != "undefined" && min_price !== null) && typeof(max_price) != "undefined" && max_price !== null){
        search_data['min_price'] = min_price;
        search_data['max_price'] = max_price;
    }


    if(typeof(hostel_type) != "undefined" && hostel_type !== null){
        search_data['type'] = hostel_type;
    }

     if(typeof(checked_services) != "undefined" && checked_services !== null && checked_services.length > 0){
         search_data['services'] = checked_services;

    }

    

    search_data['current_page'] = $current_page;
    makeAjaxRequestToGetFilteredHostel(search_data);
}


//function to make the ajax request to the serve

function makeAjaxRequestToGetFilteredHostel(search_data){
    var uri = "{{ URL::to('/eze-hostels/search') }}";
    $.ajax({
        url: uri,
        cache:false,
        processing: false,
        type:"GET",
        data: search_data,
        success: function(response)
        {
            console.log(response)
            if(response.meta_key != null){
                document.title =  response.meta_key.meta_key
            }
            
            $("#append-div").empty();
            $("#append-div").html(response.message);
            //show the ajax filter total results
            $('h5.eze-count').html('('+ response.total_record + ' EZEs Found )');
            $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $('#back-to-top').fadeIn();
                } else {
                    $('#back-to-top').fadeOut();
                }
            });
            $('body,html').animate({
                    scrollTop: 0
            }, 400);
            init_carousel()
        }
    });

}




</script>
@endsection