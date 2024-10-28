@extends('front.layouts.master')
@section('title')
User Dashboard
@endsection
@section('css')
<style>
.invalid-feedback{
    color:red;
    display: block;
}
.success-feedback{
    color:blue;
    display: block;
}
#city, #sub-city, #room-type, #hostel-type {
    border: 1px solid lightgray;
    padding: 0;
    margin: 0;
    font-weight: 500;
}
i.form-control.text-center.add_more {
    background-color: #020afb;
    color: black;
    
    cursor: pointer;
}
i.form-control.text-center.minus_more {
    background-color: red;
    color: black;
    
    cursor: pointer;
}
a.btn-primary.btn-sm{
    text-decoration: none;
}
.btn-primary {
    color: #fff;
    background-color: #ff0000;
    border-color: #060606;
}
</style>
@endsection
@section('content')
<div class="main-content">
<section id="warden-dashboard">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 mb-3 sidetab" style="border-right: 1px solid #e1e2e3; min-height:400px;">
                <ul class="nav flex-column" id="myTab" role="tablist">
                    @if(Auth::check() && Auth::user()->type == 'vendor' && Auth::user()->status == 'accepted')
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="hostel-tab" data-toggle="tab" href="#hostel" role="tab" aria-controls="hostel" aria-selected="true">Hostel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="gallery-tab" data-toggle="tab" href="#gallery" role="tab" aria-controls="gallery" aria-selected="true">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pricing-tab" data-toggle="tab" href="#pricing" role="tab" aria-controls="pricing" aria-selected="false">Pricing & Seats</a>
                    </li>
                    
                    @elseif(Auth::check() && Auth::user()->type == 'user')
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                    </li>
                    @else
                    <div class="text-center">
                            <h3>Account not approved</h3>
                    </div>
                    @endif
                </ul>
            </div>
            <div class="col-md-10">
                <div class="tab-content" id="myTabContent">
                    @if(Auth::check() && Auth::user()->type == 'vendor' && Auth::user()->status == 'accepted')
                    
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3>Profile</h3>
                        @if(Session::has('vendor-msg'))
                        <span class="success-feedback" role="alert">
                            <strong>{{ Session::get('vendor-msg') }}</strong>
                        </span>
                        @endif
                        <hr style="margin: 10px 0;">
                            <form method="POST" action="{{ route('updatevendor') }}">
                            @csrf
                            <input type="hidden" name="vendor_id" value="{{ auth::user()->id }}">
                            <div class="row">
                                <div class="col-md-12">
                                <div class="input-label">Owner's Name:</div>
                                <input type="text" name="name" value="{{ auth::user()->name }}"/>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="row"  style="margin-top: 10px;">
                                <div class="col-md-4">
                                    <div class="input-label">Owner's Address:</div>
                                    <input type="text" name="address" value="{{ auth::user()->address }}"/>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="input-label">Owner's Contact Number:</div>
                                    <input type="text" name="phone" value="{{ auth::user()->phone }}"/>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="input-label">Owner's Email Address:</div>
                                    <input type="text" name="email" value="{{ auth::user()->email }}"/>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-label">Hostel's Name:</div>
                                    <input type="text" name="hostel_name" value="{{ auth::user()->hostel_name }}"/>
                                    @error('hostel_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="input-label">Hostel's Address:</div>
                                    <input type="text" name="hostel_address" value="{{ auth::user()->hostel_address }}"/>
                                    @error('hostel_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-label">Password (if you need to change):</div>
                                        <input type="password" name="password"/>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-label">Confirm Password:</div>
                                        <input type="password" name="password_confirmation"/>
                                    </div>
                                </div>
                            <div class="update">
                                <button class="update-btn">Update</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="hostel" role="tabpanel" aria-labelledby="hostel-tab">
                    <h3>Hostel 
                        <a href="{{ URL::to('/easy-hostels/vendor'.'/'.auth::user()->id. '/'. 'hostels') }}" class="btn-primary btn-sm viewall">view all hostels</a>
                    </h3> 
                        @if(Session::has('hostel-add-msg'))
                        <span class="success-feedback" role="alert">
                            <strong>{{ Session::get('hostel-add-msg') }}</strong>
                        </span>
                        @endif
                        <hr style="margin: 10px 0;">
                        <form method="POST" action="{{ route('vendorhostelstore') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label><b>Name</b></label>
                                    <input type="text" name="title" class="form-control title"  placeholder="Name">
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-6"> 
                                    <label><b>Type</b></label>
                                    <select name="type" class="form-control type">
                                        <option selected disabled>Select type of hostel</option>
                                        <option value="boys">boys</option>
                                        <option value="girls">girls</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror        
                                </div>
                            </div>
                            <div class="form-group row">
                                    <div class="col-md-6">
                                        <label><b>City</b></label>
                                        <select name="city" class="form-control city" id="city">
                                            @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                            
                                        </select> 
                                    </div>
                                    <div class="col-md-6"> 
                                        <label><b>Place</b></label>
                                        <select name="place" class="form-control place" id="place">
                                        @error('place')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                            
                                        </select>        
                                    </div>
                            </div>
                            <div class="form-group row">
                                    <div class="col-md-6">
                                        <label><b>Description</b></label>
                                        <textarea name="description" id="description" class="form-control description"  placeholder="Description" data-msg="Description shouldn't be empty!"></textarea> 
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6"> 
                                        <label><b>Policies</b></label>
                                        <textarea name="policies" id="policies" class="form-control policies"  placeholder="Policies"></textarea> 
                                        @error('policies')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror       
                                    </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="image"><b>Image</b></label>
                                    <div id="upload_prev">
                                        <img id="hostel_preview_image" src="" width="100%" height="300" />
                                    </div>
                                    <div class="custom-file overflow-hidden rounded-pill">
                                        <input id="customFile" type="file" class="custom-file-input rounded-pill image" name="image"> 
                                        <label for="customFile" class="custom-file-label rounded-pill">Choose file</label>
                                    </div>     
                                </div>
                            </div>
                            <div class="form-group">
                                <label><b>Services</b></label>
                                <div class="row" id="main-div">
                                
                                </div>
                                @error('service')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label><b>Hostel Location Google Map Iframe</b></label>
                                    <input type="text" name="iframe" class="form-control iframe">
                                    @error('iframe')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>
                                <div class="col-md-6">
                                    <label><b>Price (your best price based on room type)</b></label>
                                    <input type="number" name="price" class="form-control price">
                                </div>
                                
                            </div>
                            
                            <div class="update">
                                <button class="update-btn">Save Changes</button>
                            </div>
                            
                        </form>
                    </div>
                    <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                        <h3>Gallery
                            <a href="{{ URL::to('/easy-hostels/vendor'.'/'.auth::user()->id. '/'. 'hostels-gallery') }}" class="btn-primary btn-sm viewall">view all hostels gallery images</a>
                        </h3>
                        @if(Session::has('hostel-gallery-msg'))
                        <span class="success-feedback" role="alert">
                            <strong>{{ Session::get('hostel-gallery-msg') }}</strong>
                        </span>
                        @endif
                        <hr style="margin: 10px 0;">
                        <p>Images Upload/You can choose multiple image for gallery</p>
                        <form method="POST" action="{{ route('vendorhostelgallerystore') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    @php
                                        $hostels = DB::table('hostels')->where('vendor_id',auth::user()->id)->get();
                                    @endphp
                                    <label><b>Hostel</b></label>
                                    <select name="hostel" class="form-control hostel"  id="hostels" required>
                                        <option disabled="disabled" selected="selected">Please select hostel</option>
                                        @foreach($hostels as $hostel)
                                        <option value="{{ $hostel->id }}">{{ $hostel->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('hostel')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                
                                <div class="col-md-12">
                                    <label for="image"><b>Image</b></label>
                                    {{-- <div id="upload_prev" class="gallery">
                                        <img id="hostel_gallery_preview_image" src="" width="100%" height="300" />
                                    </div> --}}
                                    <div class="custom-file overflow-hidden rounded-pill">
                                        <input id="customFile1" type="file" multiple  class="custom-file-input rounded-pill image" name="image[]">
                                        <label for="customFile1" class="custom-file-label rounded-pill">Choose file</label>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="update">
                                <button class="update-btn">Save Changes</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pricing" role="tabpanel" aria-labelledby="pricing-tab">
                        <h3>Pricing and Seats Availability
                            <a href="{{ URL::to('/easy-hostels/vendor'.'/'.auth::user()->id. '/'. 'hostels-pricing') }}" class="btn-primary btn-sm viewall">view all pricing</a>
                        </h3>
                        @if(Session::has('hostel-pricing-msg'))
                        <span class="success-feedback" role="alert">
                            <strong>{{ Session::get('hostel-pricing-msg') }}</strong>
                        </span>
                        @endif
                        <hr style="margin: 10px 0;">
                        <div class="pricing-rate">
                            <form method="POST" action="{{ route('vendorhostelpricingstore') }}">
                                @csrf
                                <input type="hidden" class="hostel-price-id"  value="">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        @php
                                            $hostels = DB::table('hostels')->where('vendor_id',auth::user()->id)->get();
                                        @endphp
                                        <label><b>Hostel</b></label>
                                        <select name="hostel" class="form-control hostel"  id="hostels">
                                            <option disabled="disabled" selected="selected">Please select hostel</option>
                                            @foreach($hostels as $hostel)
                                            <option value="{{ $hostel->id }}">{{ $hostel->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('hostel')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label><b>Room Type</b></label>
                                        <select name="room_type" class="form-control room_type" data-msg="Please select room type ">
                                            <option selected disabled>Select room type </option>
                                            <option value="single">single</option>
                                            <option value="shared(2)">shared(2)</option>
                                            <option value="shared(3)">shared(3)</option>
                                            <option value="shared(4)">shared(4)</option>
                                            <option value="shared(5)">shared(5)</option>
                                        </select>
                                        @error('room_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label><b>Available Room</b></label>
                                        <input type="number" name="available_room" class="form-control available_room">
                                    </div>
                                    
                                </div>
                                <div class="form-group main-div">
                                    
                                    
                                    
                                </div>
                                    @error('pricing')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                
                                <div class="update">
                                    <button class="update-btn">Save Changes</button>
                                </div>
                            </form>
                        </div>								
                    </div>
                    	
                    @elseif(auth::check() && auth::user()->type == 'user')
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3>Profile</h3>
                        @if(Session::has('msg'))
                        <span class="success-feedback" role="alert">
                            <strong>{{ Session::get('msg') }}</strong>
                        </span>
                        @endif
                        <hr style="margin: 10px 0;">
                        <form method="POST" action="{{ route('updateuser') }}">
                        @csrf
                            <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-label">Name:</div>
                                    <input type="text" name="name" value="{{ auth::user()->name }}"/>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row"  style="margin-top: 10px;">
                                <div class="col-md-4">
                                    <div class="input-label">Address:</div>
                                    <input type="text" name="address" value="{{ auth::user()->address }}"/>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="input-label">Contact Number:</div>
                                    <input type="text" name="phone" value="{{ auth::user()->phone }}"/>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="input-label">Email Address:</div>
                                    <input type="text" name="email" value="{{ auth::user()->email }}"/>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-label">Password: (optional)</div>
                                    <input type="password" name="password"/>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="input-label">Confirm Password:</div>
                                    <input type="password" name="password_confirmation"/>
                                </div>
                                
                            </div>
                            <div class="update">
                                <button type="submit" class="update-btn">Update</button>
                            </div>
                        </form>
                    </div>
                    @else
                    <div class="text-center">
                            <h3>Please wait for account approval</h3>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection
@section('js')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
$(document).ready(function(){
    /* tinymce editor */
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

    /* hiding update success flash message */
    setTimeout( "$('.success-feedback').hide();", 4000);

    /* file upload preview */
    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#' + id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#customFile").change(function () {
        readURL(this, 'hostel_preview_image');
    });

    /* loading city place services to add form */
    $('#city').empty();
    $('#city').prepend('<option disabled="disabled" selected="selected">Please select city</option>');
    $.get("{{URL::to('/getallcities')}}", function(data){
        // console.log(data.result);
        if(data.status == "success"){
            $.each(data.result, function( key, value ) {
                $('#city').append($('<option>', { 
                        value: value.title,
                        text : value.title,
                })); 
            });
        }
    });
    $("#place").prop("disabled", true);
    $('#place').prepend('<option  selected="selected">Loading cities...</option>');
    $('#city').on('change', function(){
        var id = $(this).val().toLowerCase();
        $('#place').empty();
        $.get("{{URL::to('/getplacebycityid')}}"+ "/" + id, function(data){
            // console.log(data.result);
            if(data.status == "success"){
                if(data.result.length > 0){
                    $("#place").prop("disabled", false);
                    $('#place').prepend('<option selected disabled>... select place ...</option>');
                    
                    $.each(data.result, function( key, value ) {
                        $('#place').append($('<option>', { 
                                value: value.title,
                                text : value.title,
                        }));
                        
                    });
                }else{
                    $('#place').prepend('<option>... select place ...</option>');
                    $("#place").prop("disabled", true);
                    // $('#catSubCatForm').submit();
                    
                }
            }
        });
    })
    $('#main-div').empty();
    $.get("{{ URL::to('/getallservices') }}", function(data){
        // console.log(data.result);
        $.each(data.result, function( key, value ) {
            var title = value.title
            // console.log(value.title);
            $('#main-div').append('<div class="col-md-3"><input class="service" name="service[]" id="service" type="checkbox" value="'+ title +'"> <label>'+ title +'</label></div>');  
        });
    });
    /* add more field for hostel pricing */
    $(".main-div").append('<div class="row"><div class="col-md-4"><label><b>Pricing Type</b></label><select name="pricing[]" class="form-control pricing" data-msg="Please select pricing type " ><option selected disabled>Select pricing type </option><option value="1 month">1 month</option><option value="3 months">3 months</option><option value="6 months">6 months</option><option value="1 years">1 years</option></select></div><div class="col-md-4"><label><b>Price</b></label><input type="number" name="price[]" class="form-control price"  placeholder="Price" ></div><div class="col-md-4"><div class="pricing_add_more"><label><b>add more</b></label><br><i class="form-control text-center add_more">add more</i></div></div></div>')

    /* while add more button click */
    
    $(document).on('click',".add_more",function(e){
        e.preventDefault()
        $(".main-div").append('<div class="row"><div class="col-md-4"><label><b>Pricing Type</b></label><select name="pricing[]" class="form-control pricing" data-msg="Please select pricing type " ><option selected disabled>Select pricing type </option><option value="1 month">1 month</option><option value="3 months">3 months</option><option value="6 months">6 months</option><option value="1 years">1 years</option></select></div><div class="col-md-4"><label><b>Price</b></label><input type="number" name="price[]" class="form-control price"  placeholder="Price" ></div><div class="col-md-4"><div class="pricing_add_more"><label><b>Remove</b></label><br><i class="form-control text-center minus_more">remove</i></div></div></div>')
    });
    $(".main-div").on("click",".minus_more", function(e){ 
        e.preventDefault();
		$(this).parent('div').parent('div').parent('div').remove(); //remove input field
		
    })
})
</script>
@endsection