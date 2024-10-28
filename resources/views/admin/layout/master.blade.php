<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EZE Hostel Search</title>
    <!-- Favicon -->
    {{-- <link href="./assets/img/brand/favicon.png" rel="icon" type="image/png"> --}}
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('assets/admin/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
    <link href="{{ asset('assets/admin/css/argon-dashboard.css?v=1.1.0') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/custom.css') }}" rel="stylesheet" />
    {{-- datatable --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/jquery.dataTables.css') }}">
    {{-- hiding text editor notification --}}
    <style>
        .tox-notifications-container{
          display: none;
        }
    </style>
    @yield('css')
</head>

<body class="">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md " id="sidenav-main">
    <div class="container-fluid">
      
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        
        <!-- Form -->
        <form class="mt-4 mb-3 d-md-none">
          <div class="input-group input-group-rounded input-group-merge">
            <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <span class="fa fa-search"></span>
              </div>
            </div>
          </div>
        </form>
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item">
          <a class=" nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"> <i class="ni ni-tv-2 text-primary"></i> <b>Dashboard</b>
            </a>
          </li>
           <li class="nav-item">
                <a class=" nav-link {{ request()->routeIs('cityads') ? 'active' : '' }}" href="{{ route('cityads') }}"> <i class="ni ni-tv-2 text-primary"></i> <b>City Ads</b>
                </a>
            </li>
            <li class="nav-item">
                <a class=" nav-link {{ request()->routeIs('placeads') ? 'active' : '' }}" href="{{ route('placeads') }}"> <i class="ni ni-tv-2 text-primary"></i> <b>Place Ads</b>
                </a>
            </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('bookings') ? 'active' : '' }}" href="{{ route('bookings') }}">
              <i class="ni ni-planet text-blue"></i> <b>Hostel Booking</b>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('logo') ? 'active' : '' }}" href="{{ route('logo') }}">
              <i class="ni ni-planet text-blue"></i> <b>Site Logo</b>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('city') ? 'active' : '' }}" href="{{ route('city') }}">
              <i class="ni ni-pin-3 text-orange"></i> <b>City</b>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('place') ? 'active' : '' }}" href="{{ route('place') }}">
              <i class="ni ni-square-pin text-yellow"></i> <b>Place</b>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('hostel') ? 'active' : '' }}" href="{{ route('hostel') }}">
              <i class="ni ni-shop text-red"></i> <b>Hostel</b>
            </a>
          </li>
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('hostelprice') ? 'active' : '' }}" href="{{ route('hostelprice') }}">
                <i class="fa fa-hand-holding-usd text-green"></i> <b>Hostel Pricing</b>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('hostelgallery') ? 'active' : '' }}" href="{{ route('hostelgallery') }}">
                <i class="fa fa-images text-blue"></i> <b>Hostel  Gallery</b>
              </a>
            </li>
          
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('service') ? 'active' : '' }}" href="{{ route('service') }}">
              <i class="ni ni-settings text-pink"></i> <b>Service</b>
            </a>
          </li>
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('social') ? 'active' : '' }}" href="{{ route('social') }}">
                <i class="fa fa-share-alt text-green"></i> <b>Social</b>
              </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}" href="{{ route('blog') }}">
              <i class="fa fa-address-card text-yellow"></i> <b>Blogs</b>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('hostelowner') ? 'active' : '' }}" href="{{ route('hostelowner') }}">
              <i class="fas fa-users text-blue"></i> <b>Hostel Owner</b>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('page') ? 'active' : '' }}" href="{{ route('page') }}">
              <i class="fa fa-file text-black"></i> <b>Page Information</b>
            </a>
        </li>
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('mobileapp') ? 'active' : '' }}" href="{{ route('mobileapp') }}">
                <i class="fa fa-mobile text-white"></i> <b>Mobile App</b>
              </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('homebackgroundimage') ? 'active' : '' }}" href="{{ route('homebackgroundimage') }}">
              <i class="fa fa-image text-blue"></i> <b>Home Banner Image</b>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('offerbackgroundimage') ? 'active' : '' }}" href="{{ route('offerbackgroundimage') }}">
              <i class="fa fa-image text-blue"></i> <b>Offer Banner Image</b>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('ads') ? 'active' : '' }}" href="{{ route('ads') }}">
              <i class="fa fa-ad text-purpal"></i> <b>Site Ads Section</b>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('sitecontact') ? 'active' : '' }}" href="{{ route('sitecontact') }}">
              <i class="fa fa-phone-square text-red"></i> <b>Site Contact</b>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('metakey') ? 'active' : '' }}" href="{{ route('metakey') }}">
              <i class="fa fa-keyboard text-green"></i> <b>Meta Key Description</b>
            </a>
          </li>
        </ul>
        
      </div>
    </div>
  </nav>
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('home') }}" target="_blank">EZE Hostel</a>
        <!-- Form -->
        
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
               
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold">
                    <i class="fa fa-user"></i>
                    Easy Hostel
                  </span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              
              <!-- <a href="./examples/profile.html" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>My profile</span>
              </a>
              <a href="./examples/profile.html" class="dropdown-item">
                <i class="ni ni-settings-gear-65"></i>
                <span>Settings</span>
              </a> -->
              
             <!--  <div class="dropdown-divider"></div> -->
              <a href="{{ route('admin.logout') }}" class="dropdown-item">
                <i class="ni ni-user-run"></i>
                <span>Logout</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
    <!-- Header -->
    <div class="header  pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
         <div class="row">
            @yield('content')
         </div>
        </div>
      </div>
    </div>
    
  </div>
    <!--   Core   -->
    <script src="{{ asset('assets/admin/js/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--   Argon JS   -->
    <script src="{{ asset('assets/admin/js/argon-dashboard.min.js?v=1.1.0') }}"></script>
    <script src="{{ asset('https://cdn.trackjs.com/agent/v3/latest/t.js') }}"></script>
    {{-- jquery validation --}}
    <script src="{{ asset('assets/admin/js/jquery.validate.js') }}" type="text/javascript"></script>
    
    {{-- datatable --}}
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/admin/js/jquery.dataTables.js') }}"></script>
    {{-- sweat alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    {{-- tinymce text editor --}}
    {{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> --}}
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        var editor_config = {
          path_absolute : "/",
          selector: "textarea",
          
          height:250,
          editor_selector : "mceEditor",
            editor_deselector : "mceNoEditor",
          plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
          ],
          toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
          relative_urls: false,
          file_browser_callback : function(field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
      
            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
              cmsURL = cmsURL + "&type=Images";
            } else {
              cmsURL = cmsURL + "&type=Files";
            }
      
            tinyMCE.activeEditor.windowManager.open({
              file : cmsURL,
              title : 'Filemanager',
              width : x * 0.8,
              height : y * 0.8,
              resizable : "yes",
              close_previous : "no"
            });
          }
        };
      
        tinymce.init(editor_config);
      </script>
    {{-- page wise js --}}
    @yield('js')
</body>

</html>