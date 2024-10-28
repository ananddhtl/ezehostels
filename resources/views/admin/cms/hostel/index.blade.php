@extends('admin.layout.master')

@section('css')

<style>

.rounded-lg {

  border-radius: 1rem;

}



.custom-file-label.rounded-pill {

  border-radius: 50rem;

}



.custom-file-label.rounded-pill::after {

  border-radius: 0 50rem 50rem 0;

}

#hostel_preview_image{

    margin-top:5px;

}

#upload_prev {

  position: relative;

  -moz-box-shadow: 1px 2px 4px rgba(0, 0, 0,0.5);

  -webkit-box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);

  box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);

  padding: 10px;

  margin-bottom:5px;

  background: white;

}

.add_more_tag {

    margin-top: -2px;

}



/* Make the image fit the box */

#upload_prev img {

  width: 100%;

  border: 0px solid #8a4419;

  border-style: inset;

}

.modal-body{

   

}











</style>

@endsection

@section('content')

<div class="card" style="width: 100%">

    <div class="card-header">

        <h4 class="m-0 font-weight-bold text-primary">

        <a href="javascript:void(0)" type="button" class="btn btn-default btn-sm add-hostel">add new hostel</a>

        Services Table 

        </h4>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <div>

                <table class="stripe" id="tbl_hostel">

                    <thead class="thead-light">

                        <tr>

                            <th>S.N.</th>

                            <th>Image</th>

                            <th>Title</th>

                            <th>City</th>

                            <th>Place</th>

                          

                            <th>Type</th>

                            <th>Price</th>

                            

                            <th>Publish Hostel</th>  
                            <th>Featured</th>
                            <th>Featured Order</th>

                                                  

                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        

                    </tbody>

                </table>

            </div>

                

        </div>

    </div>

    {{-- modal --}}

    <div class="modal fade" id="hostel_modal" tabindex="-1" role="dialog">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">

            <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">×</span>

                </button>

            </div>

            <div class="modal-body">

                <form role="form" name="hostelForm" id="hostelForm" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" class="hostel-id"  value="">

                    <div class="form-group row">

                        <div class="col-md-6">

                            <label><b>Name</b></label>

                            <input type="text" name="title" class="form-control title"  placeholder="Name" required data-rule-minlength="4"  data-msg-minlength="At least four character" data-msg="Hostel name shouldn't be empty">

                        </div>

                        <div class="col-md-6"> 

                            <label><b>Type</b></label>

                            <select name="type" class="form-control type" data-msg="Please select type of hostel" required>

                                <option selected disabled>Select type of hostel</option>

                                <option value="boys">boys</option>

                                <option value="girls">girls</option>

                            </select>        

                        </div>

                    </div>

                    <div class="form-group row">

                            <div class="col-md-6">

                                <label><b>City</b></label>

                                <select name="city" class="form-control city" data-msg="Please select city" required id="city">

                                   

                                </select> 

                            </div>

                            <div class="col-md-6"> 

                                <label><b>Place</b></label>

                                <select name="place" class="form-control place" data-msg="Please select place" required id="place">

                                    

                                </select>        

                            </div>

                    </div>

                    <div class="form-group row">

                            <div class="col-md-6">

                                <label><b>Description</b></label>

                                <textarea name="description" id="description" class="form-control description"  placeholder="Description" data-msg="Description shouldn't be empty!"></textarea> 

                            </div>

                            <div class="col-md-6"> 

                                <label><b>Policies</b></label>

                                <textarea name="policies" id="policies" class="form-control policies"  placeholder="Policies"></textarea>        

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

                    </div>

                    <div class="form-group row">

                        <div class="col-md-4">

                            <label><b>Location Google Map Iframe</b></label>

                            <input type="text" name="iframe" class="form-control iframe" required data-msg="Hostel name shouldn't be empty">

                        </div>

                        <div class="col-md-4">

                            <label><b>Featured</b></label>

                            <select name="featured" class="form-control featured" data-msg="Please select featured" required>

                                <option selected disabled>Select featured</option>

                                <option value="no">no</option>

                                <option value="yes">yes</option>

                        </select>

                        </div>
                        <div class="col-md-4">

                            <label><b>Order For Making Featured</b></label>

                            <input type="number" name="hostel_order" class="form-control hostel_order">

                        </div>
                        

                    </div>

                    <div class="form-group row">

                        <div class="col-md-6">

                            <label><b>Price (per month per person single room)</b></label>

                            <input type="number" name="price" class="form-control price">

                        </div>

                        <div class="col-md-6">

                            <label><b>Publish Hostel</b></label>

                            <select name="publish" class="form-control publish" data-msg="Please select publish" required>

                                <option selected disabled>Do you want to publish hostel</option>

                                <option value="no">no</option>

                                <option value="yes">yes</option>

                        </select>

                    </div>

                    

                    

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default btn-sm saveHostel">Save changes</button>

                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>

            </div>

            </div>

        </div>

    </div>

    

</div>

{{-- view more modal --}}

<div class="modal fade" id="hostel_detail_modal" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">

        <div class="modal-content">

        <div class="modal-header">

            <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">×</span>

            </button>

        </div>

        <div class="modal-body">

           

                <div class="form-group row">

                    <div class="col-md-6">

                        <label><b>Name</b></label>

                        <input type="text" name="title" class="form-control title" disabled>

                    </div>

                    <div class="col-md-6"> 

                        <label><b>Type</b></label>

                        <select name="type" class="form-control type" disabled>

                            <option selected disabled>Select type of hostel</option>

                            <option value="boys">boys</option>

                            <option value="girls">girls</option>

                        </select>        

                    </div>

                </div>

                <div class="form-group row">

                        <div class="col-md-6">

                            <label><b>City</b></label>

                            <select name="city" id="city1" class="form-control city" disabled>

                               

                            </select> 

                        </div>

                        <div class="col-md-6"> 

                            <label><b>Place</b></label>

                            <select name="place" id="place1" class="form-control place" disabled>

                                

                            </select>        

                        </div>

                </div>

                <div class="form-group row">

                        <div class="col-md-6">

                            <label><b>Description</b></label>

                            <textarea name="description" id="description1" class="form-control description"  disabled></textarea> 

                        </div>

                        <div class="col-md-6"> 

                            <label><b>Policies</b></label>

                            <textarea name="policies" id="policies1" class="form-control policies"  disabled></textarea>        

                        </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-12">

                        <label for="image"><b>Image</b></label>

                        <div id="upload_prev">

                            <img id="hostel_preview_image1" src="" width="100%" height="300" />

                        </div>

                        <div class="custom-file overflow-hidden rounded-pill">

                            <input id="customFile" type="file" class="custom-file-input rounded-pill image" name="image" disabled> 

                            <label for="customFile" class="custom-file-label rounded-pill">Choose file</label>

                        </div>     

                    </div>

                </div>

                <div class="form-group">

                    <label><b>Services</b></label>

                    <div class="row" id="main-div1">

                        

                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-6">

                        <label><b>Hostel Location Google Map Iframe </b></label>

                        <input type="text" name="iframe" class="form-control iframe" disabled>

                    </div>

                    <div class="col-md-6">

                        <label><b>Featured</b></label>

                        <select name="featured" class="form-control featured" disabled>

                            <option selected disabled>Select featured</option>

                            <option value="no">no</option>

                            <option value="yes">yes</option>

                    </select>

                    </div>

                    

                </div>

                <div class="form-group row">

                    <div class="col-md-6">

                        <label><b>Price (your lowest price of room)</b></label>

                        <input type="number" name="price" class="form-control price" disabled>

                    </div>

                    <div class="col-md-6">

                        <label><b>Publish Hostel</b></label>

                        <select name="publish" class="form-control publish" disabled>

                            <option selected disabled>Do you want to publish hostel</option>

                            <option value="no">no</option>

                            <option value="yes">yes</option>

                    </select>

                </div>

                

                

            

        </div>

        

        </div>

    </div>

</div>

@endsection

@section('js')

<script type="text/javascript">

$(document).ready( function () {

	

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

    

    /* datatable */

    var hostel_table = $('#tbl_hostel').DataTable({

        dom: 'Bfrtip',

        LengthChange: true,

        "bProcessing": true,

       

        serverSide : true,

        processing : true,

        ajax       : {

                        url  : "{{ route('hostel.gethostel') }}",

                        type : 'GET',

                        data :{ _token: "{{csrf_token()}}"}

        },

        columns   : [

                     

              {

               "data": "id",

                render: function (data, type, row, meta) {

                    return meta.row + meta.settings._iDisplayStart + 1;

                }

              },

              {'render'  :function(data, type, JsonResultRow, meta)

                {

                    return "<img src='"+ JsonResultRow.image + "' height='100px' width='150'>";

                }

              },

              {"data" :"title" ,        'name' :'title'},

              {"data" :"city" ,         'name' :'city'},

              {"data" :"place" ,        'name' :'place'},

             

              {"data" :"type" ,         'name' :'type'},

              {"data" :"price" ,         'name' :'price'},

             

              {"data" :"publish" ,     'name' :'publish'},
              {"data" :"featured" ,     'name' :'featured'},
              {"data" :"hostel_order" ,     'name' :'hostel_order'},

             

              {"data" :"action" ,       'name' :'action'},

          

        ]

    });//end of datatable

    /* image upload preview */

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

    /* csrf token setup */

    var uri,save_method;

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });



    /* when add button click */

    $('.add-hostel').on('click',function(e){

        e.preventDefault();

        save_method = "add";

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

        $('#place').empty();

        $('#place').prepend('<option disabled="disabled" selected="selected">Please Select place</option>');

        $.get("{{URL::to('/easy-hostel/place/getallplace')}}", function(data){

            // console.log(data.result);

            if(data.status = "success"){

                $.each(data.result, function( key, value ) {

                    $('#place').append($('<option>', { 

                            value: value.title,

                            text : value.title,

                    }));

                });

            }

        });

        $('#main-div').empty();

        $.get("{{ URL::to('/easy-hostel/service/getallservice') }}", function(data){

            // console.log(data.result);

            $.each(data.result, function( key, value ) {

                var title = value.title

                // console.log(value.title);

                $('#main-div').append('<div class="col-md-4"><input class="service" name="service[]"  type="checkbox" value="'+ title +'" required data-message="Please choose service"> <label>'+ title +'</label></div>');  

            });

        });

        $('.modal-title').text('Hostel Add Form');

        $('.saveHostel').text('Save changes');

        $('#hostel_modal').modal('show');

    });

    /* form validaion */

    var validator = $("#hostelForm").validate({

        rules: {

            title: {

                required: true,

            },

            type: {

                required: true,

            },

            image: {

                required: false,

            },

            description: {

                required: false,

            },

            city: {

                required: true,

            },

            place: {

                required: true,

            },

            service: {

                required: true,

            }

        },

        errorPlacement: function(label, element) {

            // position error label after generated textarea

            if (element.is("textarea")) {

                label.insertAfter(element.next());

            } else {

                label.insertAfter(element)

            }

        }

    });

    /* when save button click */

    $('.saveHostel').click(function(e){

        e.preventDefault();

        tinyMCE.triggerSave();

        if($('#hostelForm').valid()){

        /* check adding new data or updating existing data  */

        if(save_method == 'add')

        {

            uri = "{{route('hostel.store')}}";

        }

        else{

            var hostel_id  = $(".hostel-id").val();

            uri = "{{ URL::to('/easy-hostel/hostel/update') }}" + "/" + hostel_id;

        }

        /* form data */

        var result = new FormData($("#hostelForm")[0]);

        $.ajax({

            data: result,

            url: uri,

            type: "POST",

            dataType: 'json',

            contentType: false,

            processData: false,

            success: function (data) {

                

                if(data.status=='success'){

                    $('#hostelForm').trigger("reset");

                    $('#hostel_modal').modal('hide');

                    // based on store or update method showing alert information

                    if(save_method == 'add'){

                        const Toast = Swal.mixin({

                            toast: true,

                            position: 'top-end',

                            showConfirmButton: false,

                            timer: 3000

                        });



                        Toast.fire({

                            type: 'success',

                            title: 'Hostel Added Successfully'

                        });

                        hostel_table.ajax.reload();

                        

                    }else{

                        const Toast = Swal.mixin({

                            toast: true,

                            position: 'top-end',

                            showConfirmButton: false,

                            timer: 3000

                        });

                        Toast.fire({

                            type: 'success',

                            title: 'Hostel Updated successfully'

                        });

                        hostel_table.ajax.reload();

                        

                    }

                }

                else{

                    swal('Not allowed!!','error');

                }

            },

            error: function (data) {

                swal('Somethings error');

            }

        });

        }

    });

    /* when edit button clicked */

    $("body").on('click','.hostel-edit', function(e){

        e.preventDefault();

       

        save_method = "edit";

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

        $('#place').empty();

        $('#place').prepend('<option disabled="disabled" selected="selected">Please Select place</option>');

        var services = [];

        $.get("{{URL::to('/easy-hostel/place/getallplace')}}", function(data){

            // console.log(data.result);

           

            if(data.status = "success"){

                $.each(data.result, function( key, value ) {

                    $('#place').append($('<option>', { 

                            value: value.title,

                            text : value.title,

                    }));

                    services.push(value.title)

                });

            }

        });

        // console.log(services)

        $('#main-div').empty();

        $.get("{{ URL::to('/easy-hostel/service/getallservice') }}", function(data){

            // console.log(data.result);

            $.each(data.result, function( key, value ) {

                var title = value.title

                // console.log(value.title);

                $('#main-div').append('<div class="col-md-4"><input class="service" name="service[]"  type="checkbox" value="'+ title +'" value="'+ value.image +'"><label>'+ title +'</label></div>');  

            });

        });

        hostel_id = $(this).attr('data-hostel-id');

        $.ajax({

            url:"{{ URL::to('easy-hostel/hostel/edit') }}" + "/" + hostel_id,

            type: "GET",

            dataType: 'json',

            success: function (data) {

                // console.log(data.result.description)

                if(data.status == "success"){

                    $('.modal-title').text("Update Hostels");

                    $('.hostel-id').val(data.result.id);

                    $('.title').val(data.result.title);

                    $('.type').val(data.result.type);

                    $('.city').val(data.result.city);

                    $('.featured').val(data.result.featured);
                    $('.hostel_order').val(data.result.hostel_order);

                    $('.publish').val(data.result.publish);

                    $('.place').val(data.result.place);

                    $('.price').val(data.result.price);

                    $('.iframe').val(data.result.iframe);

                   /* show all  service while update */

                    

                    tinyMCE.get('description').setContent(data.result.description)

                    $('.description').val(data.result.description);

                    if(data.result.policies){

                        tinyMCE.get('policies').setContent(data.result.policies)

                        $('.policies').val(data.result.policies);

                    }



                    var image="{{asset('/uploads/hostels')}}" + "/" +data.result.image;

                    $("#hostel_preview_image").attr('src',image);

                    

                    $('.saveHostel').text("Update changes");

                    $('#hostel_modal').modal('show');

                }

            },

            error: function (data) {

                console.log('Error:', data);

            }

        });

    });



    /* when view detail clicked */

    $("body").on('click','.hostel-detail', function(e){

        e.preventDefault();

       

        $('#city1').empty();

        $('#city1').prepend('<option disabled="disabled" selected="selected">Please select city</option>');

        $.get("{{URL::to('/easy-hostel/city/getallcity')}}", function(data){

            // console.log(data.result);

            if(data.status == "success"){

                $.each(data.result, function( key, value ) {

                    $('#city1').append($('<option>', { 

                            value: value.title,

                            text : value.title,

                    })); 

                });

            }

        });

        $('#place1').empty();

        $('#place1').prepend('<option disabled="disabled" selected="selected">Please Select place</option>');

        var services = [];

        $.get("{{URL::to('/easy-hostel/place/getallplace')}}", function(data){

            // console.log(data.result);

           

            if(data.status = "success"){

                $.each(data.result, function( key, value ) {

                    $('#place1').append($('<option>', { 

                            value: value.title,

                            text : value.title,

                    }));

                    

                });

            }

        });

        // console.log(services)

        

        hostel_id = $(this).attr('data-hostel-id');

        $.ajax({

            url:"{{ URL::to('easy-hostel/hostel/show') }}" + "/" + hostel_id,

            type: "GET",

            dataType: 'json',

            success: function (data) {

                

                if(data.status == "success"){

                    $('.modal-title').text("Hostel Details");

                    $('#main-div1').empty();

                    $.each(JSON.parse(data.result.service), function( key, value ) {

                            var title = value.title

                            

                            $('#main-div1').append('<div class="col-md-3"><input class="service"   type="checkbox" disabled><label>'+   value +'</label></div>');  

                    });

                    $('.title').val(data.result.title);

                    $('.type').val(data.result.type);

                    $('.city').val(data.result.city);

                    $('.featured').val(data.result.featured);

                    $('.publish').val(data.result.publish);

                    $('.place').val(data.result.place);

                    $('.price').val(data.result.price);

                    $('.iframe').val(data.result.iframe);

                    

                   /* show all  service while update */

                   

                    tinyMCE.get('description1').setContent(data.result.description)

                    $('.description').val(data.result.description);



                    if(data.result.policies){

                       

                        tinyMCE.get('policies1').setContent(data.result.policies)

                        $('.policies').val(data.result.policies);

                    }



                    var image="{{asset('/uploads/hostels')}}" + "/" +data.result.image;

                    $("#hostel_preview_image1").attr('src',image);

                    

                   

                    $('#hostel_detail_modal').modal('show');

                }

            },

            error: function (data) {

                console.log('Error:', data);

            }

        });

    });

    

    /* when delete button clicked */

    $("body").on('click','.hostel-delete', function(e){

        e.preventDefault();

        hostel_id  = $(this).attr('data-hostel-id');

        Swal.fire({

            title: 'Are you sure?',

            text: "You won't be able to revert this!",

            type: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#3085d6',

            cancelButtonColor: '#d33',

            confirmButtonText: 'Yes, delete it!'

        }).then((result) => {

            if (result.value) {

                $.ajax({

                    url:"{{URL::to('easy-hostel/hostel/delete')}}" + "/" + hostel_id,

                    type:"GET",

                    dataType:"Json",

                    data:{_token:"{{csrf_token()}}"},

                    success:function(data){

                        if(data.status == "success")

                        {

                            const Toast = Swal.mixin({

                                toast: true,

                                position: 'top-end',

                                showConfirmButton: false,

                                timer: 3000

                            });



                            Toast.fire({

                                type: 'success',

                                title: 'Hostel Deleted successfully'

                            });

                            hostel_table.ajax.reload();

                            

                        }

                        else

                        {

                            swal('Not allowed!!','error');

                            

                        }

                    },

                });

            }

            else{

                Swal.fire(

                    'Cancelled',

                    'Your content is safe :)',

                    'error'

                )

            }

        })

    });





    /* reset form field when modal closed */

    $('.modal').on('hidden.bs.modal', function () {

        $('#hostelForm')[0].reset();

        $("#hostelForm").validate().resetForm();

        $("div .modal-footer").show();

        $("div .custom-file").show();

		

        $('#hostel_preview_image').attr('src', '');

    })

});

</script>

@endsection