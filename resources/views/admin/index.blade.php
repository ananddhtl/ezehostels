@extends('admin.layout.master')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-4">
			
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Hostel</h5>
                      <span class="h2 font-weight-bold mb-0">{{ DB::table('hostels')->count() }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  
                </div>
              
            </div>
		</div>
		<div class="col-md-4">
			
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Booking</h5>
                      <span class="h2 font-weight-bold mb-0">{{ DB::table('bookings')->count() }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  
                </div>
              
            </div>
		</div>	
		<div class="col-md-4">
			
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Hostel Owner</h5>
                      <span class="h2 font-weight-bold mb-0">{{ DB::table('users')->where('type','vendor')->count() }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  
                </div>
              
            </div>
		</div>
	</div>
</div>
@endsection