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

.btn-primary {

    color: #fff;

    background-color: #ff0000;

    border-color: #060606;

}



</style>

@endsection

@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">

            <h3>Gallery

                <a href="{{ URL::to('/easy-hostels/vendor'.'/'.auth::user()->id. '/'. 'hostels-gallery') }}" class="btn-primary btn-sm viewall">view all hostels gallery images</a>

            </h3>

                

            <hr style="margin: 10px 0;">

            <p>Images Upload</p>

            <form method="POST" action="{{ route('vendorhostelgalleryupdate',$gallery->id) }}" enctype="multipart/form-data">

                @csrf

                <div class="form-group row">

                    <div class="col-md-12">

                        @php

                            $hostels = DB::table('hostels')->where('vendor_id',auth::user()->id)->get();

                        @endphp

                        <label><b>Hostel</b></label>

                        <select name="hostel" class="form-control hostel"  id="hostels" required>

                           

                            @foreach($hostels as $hostel)

                            <option {{ $gallery->id == $hostel->id ? 'selected' : ''}} value="{{ $hostel->id }}">{{ $hostel->title }}</option>

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

                        <div id="upload_prev" class="gallery">

                        <img id="hostel_gallery_preview_image" src="{{ asset('uploads/hostelgallery'.'/'.$gallery->image) }}" width="100%" height="300" />

                        </div>

                        <div class="custom-file overflow-hidden rounded-pill">

                            <input id="customFile" type="file" multiple  class="custom-file-input rounded-pill image" name="image">

                            <label for="customFile" class="custom-file-label rounded-pill">Choose file</label>

                        </div>

                    </div>

                    

                </div>

                <div class="update">

                    <button class="update-btn">Save Changes</button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@section('js')

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>

$(document).ready(function(){



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

        readURL(this, 'hostel_gallery_preview_image');

    });

  

});

</script>

@endsection