@extends('front.layouts.master')
@section('content')
<div class="main-content">
<section id="error404" style="background: linear-gradient(0deg,rgba(255,0,0,0.7),rgba(255,0,0,0.7)),url({{ asset('uploads/hostel.jpg')}}); background-size: cover; background-position: center; padding-top: 120px;">
    <div class="container-fluid">
        <div class="col-md-6 mx-auto text-center">
            <div class="row">
                <div class="col-sm-4">
                    <img class="error-img" src="{{ asset('uploads/404.png') }}"/>
                </div>
                <div class="col-sm-8 text-left">
                    <p style="font-weight: 800; font-size: 120px; color: white; margin:0; line-height: 120px;">500</p>
                    <p style="font-size: 20px; color: white;">Oops! Somethings error.</p>
                    <a role="button" href="{{ route('home') }}" style="text-decoration: none; background: #1c1c1c; color: white; padding: 10px 25px;">Back To Home</a>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection