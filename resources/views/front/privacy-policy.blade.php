@extends('front.layouts.master')
@section('content')
<div class="main-content">
@if(!empty($privacypolicy))
<section id="service-banner" style="background: linear-gradient(0deg,rgba(255,0,0,0.7),rgba(255,0,0,0.7)),url({{ asset('uploads/pages'.'/'.$privacypolicy->background_image )}}); background-size: cover; background-position: center;">
    <div class="container-fluid">
        <div class="text-center">
            <h1 class="service-banner-title">{{ $privacypolicy->subtitle }}</h1>
        </div>
    </div>
</section>

<section id="about-body">
    <div class="container-fluid">
        <p style="text-align: justify">{!! $privacypolicy->description !!}</p>
    </div>
</section>
@else 
<section id="service-banner" style="background: linear-gradient(0deg,rgba(255,0,0,0.7),rgba(255,0,0,0.7))">
    <div class="container-fluid">
        <div class="text-center">
            <h1 class="service-banner-title">No Any Privacy Policy</h1>
        </div>
    </div>
</section>

@endif
</div>
@endsection