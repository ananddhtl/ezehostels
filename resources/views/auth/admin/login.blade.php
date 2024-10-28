<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EZE Hostel Search</title>
    <!-- Favicon -->
    <link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('assets/admin/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ asset('assets/admin/css/argon-dashboard.css?v=1.1.0') }}" rel="stylesheet" />
    <style>
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 80%;
            color: red;
        }
    </style>
</head>

<body class="bg-default">
  <div class="main-content">
    <!-- Navbar -->
    
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8">
     
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-lg-5">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              <form role="form" method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control @error('email') is-invalid @enderror" placeholder="Email" type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    
                  </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                        </div>
                        <input class="form-control @error('password') is-invalid @enderror" placeholder="Password" id="password" type="password" name="password" required autocomplete="current-password">
                        
                    </div>
                   
                </div>
                <div class="custom-control custom-control-alternative custom-checkbox">
                    <input class="custom-control-input" id=" customCheckLogin" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for=" customCheckLogin">
                        <span class="text-muted">Remember me</span>
                    </label>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary my-4">Sign in</button>
                </div>
                
              </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12 text-center">
                <a href="{{ route('admin.request') }}" class="text-light"><small>Forgot password?</small></a>
            </div>
            
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
</body>

</html>