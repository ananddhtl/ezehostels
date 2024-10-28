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

#city, #sub-city, #room-type, #hostel-type {

    border: 1px solid lightgray;

    padding: 0;

    margin: 0;

    font-weight: 500;

}



a.btn-primary.btn-sm{

    text-decoration: none;

}



</style>

@endsection

@section('content')

<div class="main-content">
<div class="container-fluid">

    

    <div class="row">

        <div class="col-md-12">

            <h3>Edit Hostel 

                <a href="{{ URL::to('/easy-hostels/vendor'.'/'.auth::user()->id. '/'. 'hostels') }}" class="btn-primary btn-sm viewall">view all hostels</a>

            </h3> 

                        

            <hr style="margin: 10px 0;">

            <form method="POST" action="{{ route('vendorhostelupdate',$hostel->id) }}" enctype="multipart/form-data">

                @csrf

                
                

                <div class="form-group row">

                    <div class="col-md-6">

                        <label><b>Name</b></label>

                        <input type="text" name="title" class="form-control title"  placeholder="Name" value="{{ $hostel->title }}">

                        @error('title')

                        <span class="invalid-feedback" role="alert">

                            <strong>{{ $message }}</strong>

                        </span>

                        @enderror

                    </div>

                    <div class="col-md-6"> 

                        <label><b>Type</b></label>

                        <select name="type" class="form-control type">

                            

                            <option {{ $hostel->type == 'boys' ? 'selected' : '' }} value="boys">boys</option>

                            <option {{ $hostel->type == 'girls' ? 'selected' : '' }} value="girls">girls</option>

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

                            

                                

                            </select> 

                            @error('city')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                            @enderror

                        </div>

                        <div class="col-md-6"> 

                            <label><b>Place</b></label>

                            <select name="place" class="form-control place" id="place">

                            

                                

                            </select> 

                            @error('place')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                            @enderror       

                        </div>

                </div>

                <div class="form-group row">

                        <div class="col-md-6">

                            <label><b>Description</b></label>

                            <textarea name="description" id="description" class="form-control description"  placeholder="Description" data-msg="Description shouldn't be empty!">{!! $hostel->description !!}</textarea> 

                            @error('description')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                            @enderror

                        </div>

                        <div class="col-md-6"> 

                            <label><b>Policies</b></label>

                            <textarea name="policies" id="policies" class="form-control policies"  placeholder="Policies">{!! $hostel->policies !!}</textarea> 

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

                        <img id="hostel_preview_image" src="{{ asset('uploads/hostels'.'/'.$hostel->image) }}" width="100%" height="300" />

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

                        <label><b>Hostel Location Google Map Iframe Src Only</b></label>

                        <input type="text" name="iframe" class="form-control iframe" value="{{ $hostel->iframe }}">

                        @error('iframe')

                        <span class="invalid-feedback" role="alert">

                            <strong>{{ $message }}</strong>

                        </span>

                        @enderror

                    </div>

                    <div class="col-md-6">

                        <label><b>Price (per month per person single room)</b></label>

                        <input type="number" name="price" class="form-control price" value="{{ $hostel->price }}">

                    </div>

                    

                </div>

                

                <div class="update">

                    <button class="update-btn">Save Changes</button>

                </div>

                

            </form>

        </div>

    </div>

</div> 
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

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",

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

    $.get("{{URL::to('/easy-hostel/city/getallcity')}}", function(data){

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

    $.get("{{ URL::to('/easy-hostel/service/getallservice') }}", function(data){

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