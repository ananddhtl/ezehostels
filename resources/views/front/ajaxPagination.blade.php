@extends('front.layouts.master')

@section('css')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/price_range_style.css') }}"/>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/jquery-ui.css') }}"/>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>

<style>

b.type {

    text-transform: capitalize;

}



</style>

@endsection

@section('content')

<div class="main-content">

<section id="hostel-listing">

    <div class="container">

        <div class="row">

            <div class="col-md-3 order-sm-1 order-2 filter">

                <div class="filter-section">

                    <h6 class="filter-sidebar-title">Filter by Location</h6>

                    <hr style="margin: 8px 0;">

                    <div class="location-filter">

                        <form>

                           

                            <select id="city-filter">

                                @foreach($cities as $city)

                                <option value="{{ $city->title }}">{{ ucfirst(trans($city->title)) }}</option>

                                @endforeach

                                

                            </select>

                            

                            <select id="sub-city-filter">

                                

                            </select>

                        </form>

                    </div>

                    

                    <div class="type-filter">

                        <h6 class="filter-sidebar-title">Filter by Type</h6>

                        <hr style="margin: 8px 0;">

                        <form>

                            

                            <div class="">

                                <input id="checkboys" class="type" type="checkbox" name="type" value="boys">

                                <label for="boys">Boys Hostel</label>

                                <span></span>

                            </div>

                            <div class="">

                                <input id="checkgirls" class="type" type="checkbox" name="type" value="girls">

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
                    @if($count)
                    <h5 class="eze-count">( {{ $count }} EZEs Found )</h5>
                    @endif

                    <div class="sort text-right">

                        <form>

                            <span class="sorting">

                            Sort By

                                <select class="sort-filter">

                                    <option value="low_to_high">Price Low to High</option>

                                    <option value="high_to_low">Price High to Low</option>

                                </select>

                            </span>

                        </form>								

                    </div>

                    @csrf

                    <div id="append-div">

                        @include('front.pagination')

                    </div>

                     

                </div>

            </div>

            

        </div>

    </div>

</section>





@endsection

@section('js')



<script type="text/javascript" src="{{ asset('assets/front/js/jquery.ui.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/front/js/price_range_script.js') }}"></script>



<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>



<script>

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



        $('li').removeClass('active');

        $(this).parent('li').addClass('active');



        var myurl = $(this).attr('href');

        var page=$(this).attr('href').split('page=')[1];



        getData(page);

     

    });

  

    var services = [];

    /* hostel filter by city */

    $("#sub-city-filter").prop("disabled", true);

    

    $('#city-filter').on('change', function(){

        

        /* checking along with city other field value */

        var city         = $(this).val().toLowerCase();

        var place        = $("#sub-city-filter").val();

        

        if($('#checkboys').prop('checked')) {

           var type     = $('#checkboys').val();

        }

        if($('#checkgirls').prop('checked')) {

           var type     = $('#checkgirls').val();

        }

        var min_value   = $("#min_price").val();

        var max_value   = $("#max_price").val(); 

        var sort        = $(".sort-filter :selected").val();



        /* calling ajax */

        var uri         = "{{ URL::to('/eze-hostels/hostel-filter') }}";

        $.ajax({

            

            url: uri,

            cache: false,

            type:"GET",

            data: {city:city,place:place, type:type, min_value:min_value, max_value:max_value, sort:sort, services:services},

            success: function(data)

            {

               

                $("#append-div").empty();

               

                $("#append-div").html(data);

                init_carousel()

            }

        });

        



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

                }else{

                    

                    $("#sub-city-filter").prop("disabled", true);

                    // $('#catSubCatForm').submit();

                    

                }

            }

        });

    });

   



    /* hostel filter by place */

    $('#sub-city-filter').on('change', function(){

        

        /* checking along with city other field value */

        var city        = $("#city-filter").val();

        var place       = $(this).val().toLowerCase();

        

        if($('#checkboys').prop('checked')) {

           var type     = $('#checkboys').val();

        }

        if($('#checkgirls').prop('checked')) {

           var type     = $('#checkgirls').val();

        }

        var min_value   = $("#min_price").val();

        var max_value   = $("#max_price").val(); 

        var sort        = $(".sort-filter :selected").val();



        /* calling ajax */

        var uri         = "{{ URL::to('/eze-hostels/hostel-filter') }}";

        $.ajax({

            

            url: uri,

            cache: false,

            type:"GET",

            data: {city:city,place:place, type:type, min_value:min_value, max_value:max_value, sort:sort, services:services},

            success: function(data)

            {

               

                $("#append-div").empty();

               

                $("#append-div").html(data);

                init_carousel()

            }

        });

        

    });

    

    /* hostel filter by hostel type */

    $('.type').click(function() {

        $('.type').not(this).prop('checked', false);

    });

    $("#checkboys").click( function(){

        

        /* checking along with city other field value */

        var city         = $("#city-filter").val();

        var place        = $("#sub-city-filter").val();

        

        if($('#checkboys').prop('checked')) {

           var type     = $('#checkboys').val();

        }

        

        var min_value   = $("#min_price").val();

        var max_value   = $("#max_price").val(); 

        var sort        = $(".sort-filter :selected").val();



        /* calling ajax */

        var uri         = "{{ URL::to('/eze-hostels/hostel-filter') }}";

        $.ajax({

            

            url: uri,

            cache: false,

            type:"GET",

            data: {city:city,place:place, type:type, min_value:min_value, max_value:max_value, sort:sort, services:services},

            success: function(data)

            {

              

                $("#append-div").empty();

               

                $("#append-div").html(data);

                init_carousel()

            }

        });

    });

    $("#checkgirls").click( function(){

        

        /* checking along with city other field value */

        var city        = $("#city-filter").val();

        var place        = $("#sub-city-filter").val();

        

        

        if($('#checkgirls').prop('checked')) {

           var type     = $('#checkgirls').val();

        }

        var min_value   = $("#min_price").val();

        var max_value   = $("#max_price").val(); 

        var sort        = $(".sort-filter :selected").val();



        /* calling ajax */

        var uri         = "{{ URL::to('/eze-hostels/hostel-filter') }}";

        $.ajax({

            

            url: uri,

            cache: false,

            type:"GET",

            data: {city:city,place:place, type:type, min_value:min_value, max_value:max_value, sort:sort, services:services},

            success: function(data)

            {

               

                $("#append-div").empty();

               

                $("#append-div").html(data);

                init_carousel()

            }

        });

    });

    /* hostel filter by services */

   

    $('.services').click(function () {

        /* if unchecked */

        if ((index = services.indexOf($(this).val())) !== -1) {

                services.splice(index, 1);

        }

        /* when checkbox is checked */

        $('input[name="service[]"]:checked').each(function(){

            if(services.indexOf($(this).val()) == -1) {

                services.push($(this).val());

            }

        }); 

        

        /* checking along with city other field value */

        var city        = $("#city-filter").val();

        var place        = $("#sub-city-filter").val();

        

        if($('#checkboys').prop('checked')) {

           var type     = $('#checkboys').val();

        }

        if($('#checkgirls').prop('checked')) {

           var type     = $('#checkgirls').val();

        }

        var min_value   = $("#min_price").val();

        var max_value   = $("#max_price").val(); 

        var sort        = $(".sort-filter :selected").val();



        /* calling ajax */

        var uri         = "{{ URL::to('/eze-hostels/hostel-filter') }}";

        $.ajax({

            

            url: uri,

            cache: false,

            type:"GET",

            data: {city:city,place:place, type:type, min_value:min_value, max_value:max_value, sort:sort, services:services},

            success: function(data)

            {

               

                $("#append-div").empty();

               

                $("#append-div").html(data);

                init_carousel()

            }

        });

        // console.log(services) 

    });

   

    



    /* sort by price */

   

    $('body').on('change', '.sort-filter', function() {

       

        /* checking along with city other field value */

        var city        = $("#city-filter").val();

        var place       = $("#sub-city-filter").val();

        

        if($('#checkboys').prop('checked')) {

           var type     = $('#checkboys').val();

        }

        if($('#checkgirls').prop('checked')) {

           var type     = $('#checkgirls').val();

        }

        var min_value   = $("#min_price").val();

        var max_value   = $("#max_price").val(); 

        var sort        = $(this).val().toLowerCase();



        /* calling ajax */

        var uri         = "{{ URL::to('/eze-hostels/hostel-filter') }}";

        $.ajax({

            

            url: uri,

            cache: false,

            type:"GET",

            data: {city:city,place:place, type:type, min_value:min_value, max_value:max_value, sort:sort, services:services},

            success: function(data)

            {

               

                $("#append-div").empty();

               

                $("#append-div").html(data);

                init_carousel()

            }

        });

        

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



            var min_value = $("#min_price").val();

            var max_value = $("#max_price").val(); 

            

        },

        stop: function(event, ui){

            var min_value = $("#min_price").val();

            var max_value = $("#max_price").val(); 

           

            /* checking along with city other field value */

            var city        = $("#city-filter").val();

            var place        = $("#sub-city-filter").val();

            

            if($('#checkboys').prop('checked')) {

            var type     = $('#checkboys').val();

            }

            if($('#checkgirls').prop('checked')) {

            var type     = $('#checkgirls').val();

            }

           

            var sort        = $(".sort-filter :selected").val();



            /* calling ajax */

            var uri         = "{{ URL::to('/eze-hostels/hostel-filter') }}";

            $.ajax({

            

            url: uri,

            cache: false,

            type:"GET",

            data: {city:city,place:place, type:type, min_value:min_value, max_value:max_value, sort:sort, services:services},

            success: function(data)

            {

                init_carousel()

                $("#append-div").empty();

               

                $("#append-div").html(data);

                

            }

        });

           

        }

        



    });

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



});

function getData(page){

    $.ajax(

    {

        url: '?page=' + page,

        type: "get",

        datatype: "html"

    }).done(function(data){

        

        $("#append-div").empty();

        $("#append-div").html(data);
        $('body,html').animate({
                scrollTop: 0
        }, 400);
        
        
        init_carousel()

        location.hash = page;

    }).fail(function(jqXHR, ajaxOptions, thrownError){

            alert('No response from server');

    });

}

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









</script>

@endsection