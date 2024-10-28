@extends('front.layouts.master')
@section('content')
<div class="main-content">
<section id="service-banner" style="background: linear-gradient(0deg,rgba(255,0,0,0.7),rgba(255,0,0,0.7)),url('img/hostel.jpg'); background-size: cover; background-position: center;">
    <div class="container-fluid">
        <div class="text-center">
            <h1 class="service-banner-title">What We Offer</h1>
        </div>
    </div>
</section>

<section id="service-body">
    <div class="container-fluid">
        <h5 class="service-page-caption">We are always cautious about the health, safety and satisfaction of our customers thus, we provide you with the proper details of the services available in the hostel you are looking for to stay in.</h5>
    </div>
</section>

<section id="eze-service-list">
    <div class="container-fluid">
        <h4 style="text-align: center; font-weight: 700;">EZEs provide the following Facilities/Services</h4>
        <hr style="border-top: 4px solid red; width: 100px;">
        <div class="hostel-service-list">
            <div class="row">
                @foreach($services as $service)
                <div class="col-md-3">
                    <div class="eze-service-card mx-auto">
                        <span><img class="service-icon" src="{{ asset('uploads/services'.'/'.$service->image) }}"/></span>
                        <span class="service-name">{{ $service->title }}</span>
                    </div> 
                </div>
                @endforeach	
            </div>
            
        </div>
    </div>
</section>
</div>
@endsection