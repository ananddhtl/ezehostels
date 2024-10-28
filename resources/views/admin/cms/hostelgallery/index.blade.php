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
#hostel_gallery_preview_image{
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

/* Make the image fit the box */
#upload_prev img {
  width: 100%;
  border: 0px solid #8a4419;
  border-style: inset;
}
.modal-body{
    padding: 0px 20px;
}




</style>
@endsection
@section('content')
<div class="card" style="width: 100%">
    <div class="card-header">
        <h4 class="m-0 font-weight-bold text-primary">
       
        <a href="javascript:void(0)" type="button" class="btn btn-default btn-sm add-hostel-gallery">add images</a>
        
        Hostel Image Gallery Table 
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <table class="table align-items-center" id="tbl_hostel_gallery">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">S.N.</th>
                            <th scope="col">Hostel</th>  
                            <th scope="col">Image</th>                         
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        
                    </tbody>
                </table>
            </div>
                
        </div>
    </div>
    {{-- modal --}}
    <div class="modal fade" id="hostel_gallery_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" name="hostelgalleryForm" id="hostelgalleryForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="hostel-gallery-id"  value="">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><b>Hostel</b></label>
                            <select name="hostel" class="form-control hostel" data-msg="Please select hostel"  id="hostel" required>
                                
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        
                        <div class="col-md-12">
                            <label for="image">Image</label>
                            <div id="upload_prev" class="gallery">
                                <img id="hostel_gallery_preview_image" src="" width="100%" height="300" />
                            </div>
                            <div class="custom-file overflow-hidden rounded-pill">
                                <input id="customFile" type="file" multiple  class="custom-file-input rounded-pill image" name="image[]">
                                <label for="customFile" class="custom-file-label rounded-pill">Choose file</label>
                            </div>
                        </div>
                        
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm saveHostelGallery">Save changes</button>
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready( function () {
    /* datatable */
    var hostel_gallery_table = $('#tbl_hostel_gallery').DataTable({
        dom: 'Bfrtip',
        LengthChange: true,
        "bProcessing": true,
        serverSide : true,
        processing : true,
        ajax       : {
                        url  : "{{ route('hostelgallery.gethostelgallery') }}",
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
              {"data" : "hostel",  "name" : "hostel"},
              {'render'  :function(data, type, JsonResultRow, meta)
                {
                    return "<img src='"+ JsonResultRow.image + "' height='100px' width='200px'>";
                }
              },
              {"data" :"action" ,       'name' :'action'},
          
        ]
    });//end of datatable
    /* image upload preview */
    // function readURL(input, id) {
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();

    //         reader.onload = function (e) {
    //             $('#' + id).attr('src', e.target.result);
    //         }

    //         reader.readAsDataURL(input.files[0]);
    //     }
    // }
    // $("#customFile").change(function () {
    //     readURL(this, 'hostel_gallery_preview_image');
    // });
    
    /* csrf token setup */
    var uri,save_method;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* when add button click */
    $('.add-hostel-gallery').on('click',function(e){
        e.preventDefault();
        $('#hostel').empty();
        $('#hostel').prepend('<option disabled="disabled" selected="selected">Please select hostel</option>');
        $.get("{{URL::to('/easy-hostel/hostel/getallhostel')}}", function(data){
            // console.log(data.result);
            if(data.status == "success"){
                $.each(data.result, function( key, value ) {
                    $('#hostel').append($('<option>', { 
                            value: value.id,
                            text : value.title,
                    })); 
                });
            }
        });
        save_method = "add";
        $('.modal-title').text('Hostel Gallery Images Add Form');
        $('.saveHostelGallery').text('Save changes');
        $('#hostel_gallery_modal').modal('show');
    });
    /* form validaion */
    var validator = $("#hostelgalleryForm").validate({
        rules: {
            hostel:{
                required:true
            },
            image: {
                required: false,
            }
        }
    });
    /* when save button click */
    $('.saveHostelGallery').click(function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        if($('#hostelgalleryForm').valid()){
        /* check adding new data or updating existing data  */
        if(save_method == 'add')
        {
            uri = "{{route('hostelgallery.store')}}";
        }
        else{
            var hostel_gallery_id  = $(".hostel-gallery-id").val();
            uri = "{{ URL::to('/easy-hostel/hostel-gallery/update') }}" + "/" + hostel_gallery_id;
        }
        /* form data */
        var result = new FormData($("#hostelgalleryForm")[0]);
        $.ajax({
            data: result,
            url: uri,
            type: "POST",
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                
                if(data.status=='success'){
                    $('#hostelgalleryForm').trigger("reset");
                    $('#hostel_gallery_modal').modal('hide');
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
                            title: 'Hostel Gallery Image Added Successfully'
                        });
                        hostel_gallery_table.ajax.reload();
                        
                        
                    }else{
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'Hostel Gallery Image Updated successfully'
                        });
                        hostel_gallery_table.ajax.reload();
                        
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
    $("body").on('click','.hostel-gallery-edit', function(e){
        e.preventDefault();
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
       
        save_method = "edit";
        $('#hostel').prepend('<option disabled="disabled" selected="selected">Please select hostel</option>');
        $.get("{{URL::to('/easy-hostel/hostel/getallhostel')}}", function(data){
            // console.log(data.result);
            if(data.status == "success"){
                $.each(data.result, function( key, value ) {
                    $('#hostel').append($('<option>', { 
                            value: value.id,
                            text : value.title,
                    })); 
                });
            }
        });
        hostel_gallery_id = $(this).attr('data-hostel-gallery-id');
        $.ajax({
            url:"{{ URL::to('easy-hostel/hostel-gallery/edit') }}" + "/" + hostel_gallery_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                if(data.status == 'success'){
                    $('.modal-title').text("Update Hostel Gallery Image");
                    $('.hostel-gallery-id').val(data.result.id);
                    $('.hostel').val(data.result.hostel_id);
                    var image="{{asset('/uploads/hostelgallery')}}" + "/" +data.result.image;
                    $("#hostel_gallery_preview_image").attr('src',image);
                    $('.hostel-gallery-id').val(data.result.id);
                    $('#customFile').prop('multiple',false);
                    $('.saveHostelGallery').text("Update changes");
                    $('#hostel_gallery_modal').modal('show');
                }else{
                    console.log(data.error)
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    /* when view detail clicked */
    $("body").on('click','.hostel-gallery-detail', function(e){
        e.preventDefault();
        hostel_gallery_id = $(this).attr('data-hostel-gallery-id');
        $('#hostel').prepend('<option disabled="disabled" selected="selected">Please select hostel</option>');
        $.get("{{URL::to('/easy-hostel/hostel/getallhostel')}}", function(data){
            // console.log(data.result);
            if(data.status == "success"){
                $.each(data.result, function( key, value ) {
                    $('#hostel').append($('<option>', { 
                            value: value.id,
                            text : value.title,
                    })); 
                });
            }
        });
        $.ajax({
            url:"{{ URL::to('easy-hostel/hostel-gallery/show') }}" + "/" + hostel_gallery_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                
                $('.modal-title').text("Hostel Gallery Image Detail");
                $('.hostel-gallery-id').val(data.result.id);
                var image="{{asset('/uploads/hostelgallery')}}" + "/" +data.result.image;
                $("#hostel_gallery_preview_image").attr('src',image);
                $('.hostel').val(data.result.hostel_id);
                $("div .modal-footer").hide();
                $("div .custom-file").hide();
                $('#hostel').prop('disabled',true);
                $('.saveHostelGallery').text("Update changes");
                $('#hostel_gallery_modal').modal('show');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    /* when delete button clicked */
    $("body").on('click','.hostel-gallery-delete', function(e){
        e.preventDefault();
        hostel_gallery_id  = $(this).attr('data-hostel-gallery-id');
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
                    url:"{{URL::to('easy-hostel/hostel-gallery/delete')}}" + "/" + hostel_gallery_id,
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
                                title: 'Hostel Gallery Image Deleted successfully'
                            });
                            hostel_gallery_table.ajax.reload();
                            
                            
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
        $('#hostelgalleryForm')[0].reset();
        $("#hostelgalleryForm").validate().resetForm();
        $("div .modal-footer").show();
        $("div .custom-file").show();
        $('#hostel_gallery_preview_image').attr('src', '');
        $('#hostel').prop('disabled',false);
        $('#customFile').prop('multiple',true);
    })
});
</script>
@endsection