@extends('front.layouts.master')
@section('content')
<div class="main-content">
<section id="single-blog-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="blog-body">
                    <h3>{{ $blog->title }}</h3>
                    <p class="blog-body-date">
                        <span><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($blog->date)->format('d M, Y') }}</span>
                        <!-- <span class="social-share" style="float: right;">
                                Share To: 
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                        </span> -->
                    </p>
                    <img class="single-blog-img" src="{{ asset('uploads/blogs'.'/'.$blog->image)}}"/>
                    <div class="single-blog-content">
                        <p class="text-justify" style="font-size: 16px; color: dimgray;">
                            {!! $blog->description !!}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4" style="border-left: 1px solid #e1e2e3;">
                <div class="blog-sidebar">
                    <h4 style="margin: 0; font-weight: 700;">Latest Blogs</h4>
                    <hr style="border-top: 2px solid red;">
                    @foreach($blogs as $b)
                    <div class="sidebar-blog-card">
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="{{ URL::to('eze-hostels/blog'.'/'.$b->slug) }}">
                                <img class="sidebar-blog-img" src="{{ asset('uploads/blogs'.'/'.$b->image) }}"/>
                                </a>
                            </div>
                            <div class="col-sm-8">
                                
                                <span class="sidebar-blog-title">{{ $b->title }}</span>
                                <div class="blog-card-date"><i class="fa fa-clock-o"></i>  {{ \Carbon\Carbon::parse($b->date)->format('d M, Y') }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection