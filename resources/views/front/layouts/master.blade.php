<!doctype html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-155568884-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-155568884-1');
</script>

      
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('uploads'.'/'.$logo->image) }}">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('meta_tag')

    <!-- Bootstrap CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/bootstrap.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/bootstrap-grid.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/bootstrap-grid.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/bootstrap-reboot.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/bootstrap-reboot.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/custom.css') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/font-awesome.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/font-awesome.min.css') }}">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.min.css"/>
	@yield('css')
	
	<title>@yield('title')</title>
	
	<style>
		@media only screen and (max-width: 600px) {
			.nav-item {
				padding: 0;
				margin: 0 15px;
			}
			.nav-link {
				padding: .5rem;
				font-size: 15px;
			}
			.extra-nav {
    			display: flex;
			}
			.nav-item .dropdown-menu {
				margin: 0;
				width: 100%;
				height: 220px;
				overflow-y: auto;
			}
			nav.navbar.navbar-expand-lg {
				padding: 6px 14px;
			}
			#desktopSearch{
				display: none;
			}
			a#goHome {
				opacity: 0.8;
				font-size: 14px;
			    color: white;
			    position: fixed;
			    bottom: 30px;
			    left: 25px;
			    background: #000;
			    padding: 5px;
			    border-radius: 5px;
			    text-decoration: none;
			}
		}
		
		@media only screen and (min-width: 600px) {
			.extra-nav{
				display: none !important;
			}
			#mobileSearch{
				display: none;
			}
			#goHome{
				display: none;
			}
		}
		
	</style>
	  
  </head>
	<body>
		<div id="app">
			<header>
				<div class="container-fluid">
					<div id="top-header">
						<div class="d-flex" style="justify-content: space-between">
							<div class="logo">
								<a class="navbar-brand" href="{{ route('home') }}">
									@if(!empty($logo))
									<img src="{{ asset('uploads'.'/'.$logo->image) }}"  height="60" width="50"/>
									@endif
								</a>
							</div>
							
							<div class="text-right login-signup my-auto">
								
                                @if($site_contact->count() > 0)
								<div class="header-contact">
									Contact us: <a href="tel:+977{{ $site_contact->phone1 }}">+977{{ $site_contact->phone1 }}</a> / <a href="tel:+977{{ $site_contact->phone2 }}">+977{{ $site_contact->phone2 }}</a>
								</div>
								@endif
								@if(!Auth::check())
								<div class="login-signup1">
								<a style="background: red; padding: 5px 10px; border-radius: 5px; color: white;" href="{{ route('login') }}">Login</a> or <a style="background: red; padding: 5px 10px; border-radius: 5px; color: white;" href="{{ route('register') }}">Signup</a>
								</div>
								@else
								<div class="login-signup">
									@if(auth::check() && auth::user()->type == 'vendor')
									<a href="{{ route('vendordashboard') }}">Add Your Hostel</a>&nbsp;
									@else
									<a href="{{ route('vendordashboard') }}">Dashboard</a>&nbsp;
									@endif
									<a  href="{{ route('logout') }}"
										onclick="event.preventDefault();
														document.getElementById('logout-form').submit();">
										
										<i class="fa fa-sign-out" title="Sign out"></i>
									</a>

									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
									</form>
								</div>
								@endif

								<div id="mobileSearch" class="input-group md-form ml-auto">
									<form action="{{ URL::to('/eze-hostels/search') }}">
										<div class="search-by-hostel d-flex">
											<div>
												<input class="form-control my-0 py-1 amber-border" name="hostel_name" type="text" placeholder="Search By Hostel's Name" aria-label="Search" required value="{{ (\Request::get('hostel_name')) ?? ''}}">
											</div>
											<div>
												<button type="submit" style="color: red; float: right; padding: 6.5px 11px;
												border-radius: 0 8px 6px 0px;
												border: none;" class="btn-sm">
												<i class="fa fa-search" aria-hidden="true" style="font-size: 18px;"></i>
											</button>
											</div>
										</div>
									  
									</form>
								</div>
                             
							</div>
							
						</div>
					</div>
				</div>	
				<div id="main-menu">
						<nav class="navbar navbar-toggleable-md navbar-expand-lg">			
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
								<i class="fa fa-bars"></i>
							</button>			
							<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
								<ul class="navbar-nav">
                                   
                                    @foreach($cities as $city)
									<li class="nav-item">
										<div class="dropdown header">
                                            @if($city->places->count() > 0)
                                            <a class="nav-link city"  href="{{ URL::to('/eze-hostels/search'.'?city='.$city->title) }}">{{ $city->title }}</a>
                                            @else
                                            <a class="nav-link city"  href="{{ URL::to('/eze-hostels/search'.'?city='.$city->title) }}">{{ $city->title }}</a>
                                            @endif
                                            @if($city->places->count() > 0)
											  <div class="dropdown-menu">
                                                @foreach($city->places as $place)
											  	<a class="dropdown-item" href="{{ URL::to('/eze-hostels/search'.'?city='.$city->title .'&place='.$place->title) }}">{{ $place->title }}</a>
                                                @endforeach
                                              </div>
                                            @endif
										
										</div>										
                                    </li>
                                    @endforeach
									
									<li class="nav-item all">
										<a class="nav-link"  href="{{URL::to('/eze-hostels/search?city=all-over-nepal')}}">All of Nepal</a>
									</li>
									
									<li class="nav-item all">
											  <a class="nav-link dropdown" href="#" data-toggle="dropdown">
												All Cities
											  </a>

												<div class="dropdown-menu">
													@foreach($allcities as $cities)
													<a class="dropdown-item" href="{{ URL::to('/eze-hostels/search'.'?city='.$cities->title) }}">{{ $cities->title }}</a>
													@endforeach
												</div>

								    </li>
									
								</ul>
								<div id="desktopSearch" class="input-group md-form ml-auto">
									<form action="{{ URL::to('/eze-hostels/search') }}">
										<div class="search-by-hostel d-flex">
											<div>
												<input class="form-control my-0 py-1 amber-border" name="hostel_name" type="text" placeholder="Search By Hostel's Name" aria-label="Search" required value="{{ (\Request::get('hostel_name')) ?? ''}}">
											</div>
											<div>
												<button type="submit" style="color: red; float: right; padding: 8.5px 11px;
												border-radius: 0 8px 6px 0px;
												border: none;" class="btn-sm">
												<i class="fa fa-search" aria-hidden="true" style="font-size: 18px;"></i>
											</button>
											</div>
										</div>
									  
									</form>
								</div>
							</div>
							

							<div class="extra-nav">
								<span class="nav-item">
									<a class="nav-link"  href="{{ URL::to('/eze-hostels/search'.'?city=Kathmandu') }}">Kathmandu</a>  
								</span>

								<span class="nav-item">
									<a class="nav-link"  href="{{ URL::to('/eze-hostels/search'.'?city=Lalitpur') }}">Lalitpur</a>  
								</span>

								<span class="nav-item all">
											  <a class="nav-link dropdown" href="#" data-toggle="dropdown">
												All Cities
											  </a>

												<div class="dropdown-menu">
													@foreach($allcities as $cities)
													<a class="dropdown-item" href="{{ URL::to('/eze-hostels/search'.'?city='.$cities->title) }}">{{ $cities->title }}</a>
													@endforeach
												</div>

								</span>
							</div>
						</nav>
						
				</div>
			</header>
			
			@yield('content')
			
			<footer>
				<div class="container-fluid">
					<div id="footer-top">
						<div class="row">
							<div class="col-md-1 text-center">
								@if(!empty($logo))
								<a class="navbar-brand" href="#">
									<img src="{{ asset('uploads'.'/'.$logo->image) }}" height="80"/>
								</a>
								@endif
							</div>
							<div class="col-md-11">
								<h3>The Fastest and Reliable Hostel Search in Nepal</h3>
							</div>
						</div>
					</div>	
					<hr style="border-top: 1px solid gray;">
					<div id="footer-mid">
						<div class="row">
							<div class="col-md-5 first">
								
                                @if($mobile_apps->count() > 0)
                                						
								<h6 style="margin-bottom: 15px; margin-left: 10px;">Download our app on app stores.</h6>
                                <a href="{{ $mobile_apps->android_url }}"><img src="{{ asset('uploads/mobileapp'.'/'.$mobile_apps->android_image)}}" style="width: 130px; height:50px; margin: 5px;"></a>
                                <a href="{{ $mobile_apps->ios_url }}"><img src="{{ asset('uploads/mobileapp'.'/'.$mobile_apps->ios_image)}}" style="width: 130px;  height:50px; margin: 5px;"></a>
                                
                                @endif
							</div>
							<div class="col-md-4 second">
								<p><a href="{{ route('aboutus') }}">About Us</a></p>
								{{-- <a><a href="#">Our Team</a></a> --}}
								<p><a href="{{ route('blogs') }}">Blogs</a></p>
								<p><a href="{{ route('services') }}">Services</a></p>
							</div>
							<div class="col-md-3 third">
								<p><a href="{{ route('privacypolicy') }}">Privacy Policy</a></p>
								<p><a href="{{ route('termconditions') }}">Terms & Conditions</a></p>
								<p><a href="{{ route('guestpolicy') }}">Guest Policy</a></p>
							</div>
						</div>
					</div>
					<hr style="border-top: 1px solid gray;">
					@if($site_contact->count() > 0)
					<div id="footer-contact">
						<p>Got Any Queries ? Call for any assistance on <a href="tel:+977{{ $site_contact->phone1 }}">+977{{ $site_contact->phone1 }}</a> / <a href="tel:+977{{ $site_contact->phone2 }}">+977{{ $site_contact->phone2 }}</a><br>Or Mail us at <a href="mailto:{{ $site_contact->email }}">{{ $site_contact->email }}</a></p>
					</div>
					@endif
					<hr style="border-top: 1px solid gray;">
					<div id="footer-bottom">
						<div class="row">
							<div class="col-md-6">
                               
                                @if(!empty($socials))
								<div class="social">
                                    
                                    @foreach($socials as $social)
                                    <a href="{{ $social->url}}" target="_blank">
                                        <img src="{{ asset('uploads/socials'.'/'.$social->image) }}"/>
                                    </a>
									@endforeach
                                </div>
                                @endif
							</div>
							<div class="col-md-6">
								<div class="copyright">© 2019 Website Name. All Rights Reserved.<br>
									Developed by <a href="https://itarrow.com/" target="_blank" style="color:#ff0000; text-decoration: none;">IT Arrow Pvt Ltd.</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</footer>
		
		</div>
		
		<a id="goHome" href="http://ezehostels.com/"><i class="fa fa-home"></i> Home</a>

        <a id="back-to-top" href="#" class="btn back-to-top" role="button"><i class="fa fa-chevron-up"></i></a>	
        
        {{-- script --}}
		<script type="text/javascript" src="{{ asset('assets/front/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('assets/front/js/popper.min.js') }}"></script>
		
		<script type="text/javascript" src="{{ asset('assets/front/js/custom.js') }}"></script>

    
		
		<script>
		$(document).ready(function(){
			$(window).scroll(function () {
			if ($(this).scrollTop() > 50) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
		// scroll body to 0px on click
		$('#back-to-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 400);
			return false;
		});
		});
		
        </script>
        @yield('js')
	</body>
</html>