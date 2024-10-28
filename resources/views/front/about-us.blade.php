@extends('front.layouts.master')
@section('content')
@if(!empty($aboutus))
<div class="main-content">
	<section id="service-banner" style="background: linear-gradient(0deg,rgba(255,0,0,0.7),rgba(255,0,0,0.7)),url({{ asset('uploads/pages'.'/'.$aboutus->background_image )}}); background-size: cover; background-position: center;">
	    <div class="container-fluid">
	        <div class="text-center">
	            <h1 class="service-banner-title">{{ $aboutus->subtitle }}</h1>
	        </div>
	    </div>
	</section>

	<section id="about-body">
	    <div class="container-fluid">
	        <p style="text-align: justify">{!! $aboutus->description !!}</p>
	    </div>
	</section>
	@else 
	<section id="service-banner" style="background: linear-gradient(0deg,rgba(255,0,0,0.7),rgba(255,0,0,0.7))">
	    <div class="container-fluid">
	        <div class="text-center">
	            <h1 class="service-banner-title">No About Us</h1>
	        </div>
	    </div>
	</section>
</div>
@endif
@endsection