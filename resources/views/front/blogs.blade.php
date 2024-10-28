@extends('front.layouts.master')
@section('content')
<div class="main-content">
<section id="service-banner" style="background: linear-gradient(0deg,rgba(255,0,0,0.7),rgba(255,0,0,0.7)),url('img/hostel.jpg'); background-size: cover; background-position: center;">
    <div class="container-fluid">
        <div class="text-center">
            <h1 class="service-banner-title">Our Blogs</h1>
        </div>
    </div>
</section>

<section id="blog-list">
    <div class="container-fluid">	
        <div class="row">	
            @foreach($blogs as $blog)	
            <div class="col-md-4">
                <div class="blog-block mx-auto">					
                    <img class="blog-list-img" src="{{ asset('uploads/blogs'.'/'.$blog->image)}}"/>
                    <div class="blog-content">
                        <span class="blog-card-date">
                            <i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($blog->date)->format('d M, Y') }}
                        </span>
                        <h4 class="blog-title"  style="font-weight: 700;">{{ $blog->title }}</h4>
                        <p class="blog-demo-content" style="margin-bottom: 8px;">{!! str_limit($blog->description,165) !!}</p>
                        <a href="{{ URL::to('eze-hostels/blog'.'/'.$blog->slug) }}" class="blog-list-read-more">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
</div>
@endsection