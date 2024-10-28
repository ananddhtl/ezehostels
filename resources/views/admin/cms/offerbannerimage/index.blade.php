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
#offer_background_preview_image{
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
    padding: 0px 5px;
}




</style>
@endsection
@section('content')
<div class="card" style="width: 100%">
    <div class="card-header">
        <h4 class="m-0 font-weight-bold text-primary">
        @if($image->count() == 0)
        <a href="javascript:void(0)" type="button" class="btn btn-default btn-sm add-offer-background">add new image</a>
        @endif
        Offer Background Image Table 
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <table class="table align-items-center" id="tbl_offer_background_image">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">S.N.</th>
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
    <div class="modal fade" id="offer_background_image_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" name="offerbackgroundimageForm" id="offerbackgroundimageForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="offer-background-image-id"  value="">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="image">Image</label>
                            <div id="upload_prev">
                                <img id="offer_background_preview_image" src="" width="100%" height="200" />
                            </div>
                            <div class="custom-file overflow-hidden rounded-pill">
                                <input id="customFile" type="file" class="custom-file-input rounded-pill image" name="image">
                                    
                                <label for="customFile" class="custom-file-label rounded-pill">Choose file</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm saveOfferBackgroundImage">Save changes</button>
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
    var offer_background_image_table = $('#tbl_offer_background_image').DataTable({
        dom: 'Bfrtip',
        LengthChange: true,
        "bProcessing": true,
        serverSide : true,
        processing : true,
        ajax       : {
                        url  : "{{ route('offerbackgroundimage.getofferbackgroundimage') }}",
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
                    return "<img src='"+ JsonResultRow.image + "' height='100px' width='200px'>";
                }
              },
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
        readURL(this, 'offer_background_preview_image');
    });
    /* csrf token setup */
    var uri,save_method;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* when add button click */
    $('.add-offer-background').on('click',function(e){
        e.preventDefault();
        save_method = "add";
        $('.modal-title').text('Offer Background Image Add Form');
        $('.saveOfferBackgroundImage').text('Save changes');
        $('#offer_background_image_modal').modal('show');
    });
    /* form validaion */
    var validator = $("#offerbackgroundimageForm").validate({
        rules: {
            image: {
                required: false,
            }
        }
    });
    /* when save button click */
    $('.saveOfferBackgroundImage').click(function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        if($('#offerbackgroundimageForm').valid()){
        /* check adding new data or updating existing data  */
        if(save_method == 'add')
        {
            uri = "{{route('offerbackgroundimage.store')}}";
        }
        else{
            var offer_background_image_id  = $(".offer-background-image-id").val();
            uri = "{{ URL::to('/easy-hostel/offer-background-image/update') }}" + "/" + offer_background_image_id;
        }
        /* form data */
        var result = new FormData($("#offerbackgroundimageForm")[0]);
        $.ajax({
            data: result,
            url: uri,
            type: "POST",
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                
                if(data.status=='success'){
                    $('#offerbackgroundimageForm').trigger("reset");
                    $('#offer_background_image_modal').modal('hide');
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
                            title: 'Offer Background Image Added Successfully'
                        });
                        offer_background_image_table.ajax.reload();
                        setInterval(function(){ 
                                location.reload();
                        }, 1000);
                        
                    }else{
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'Offer Background Image Updated successfully'
                        });
                        offer_background_image_table.ajax.reload();
                        
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
    $("body").on('click','.offer-background-image-edit', function(e){
        e.preventDefault();
       
        save_method = "edit";
        offer_background_image_id = $(this).attr('data-offer-background-image-id');
        $.ajax({
            url:"{{ URL::to('easy-hostel/offer-background-image/edit') }}" + "/" + offer_background_image_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                
                $('.modal-title').text("Update Offer Background Image");
                $('.offer-background-image-id').val(data.result.id);
                var image="{{asset('/uploads')}}" + "/" +data.result.image;
                $("#offer_background_preview_image").attr('src',image);
                
                $('.saveOfferBackgroundImage').text("Update changes");
                $('#offer_background_image_modal').modal('show');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    /* when view detail clicked */
    $("body").on('click','.offer-background-image-detail', function(e){
        e.preventDefault();
        offer_background_image_id = $(this).attr('data-offer-background-image-id');
        $.ajax({
            url:"{{ URL::to('easy-hostel/offer-background-image/show') }}" + "/" + offer_background_image_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                
                $('.modal-title').text("Offer Background Image Detail");
                $('.offer-background-image-id').val(data.result.id);
                var image="{{asset('/uploads')}}" + "/" +data.result.image;
                $("#offer_background_preview_image").attr('src',image);
                $("div .modal-footer").hide();
                $("div .custom-file").hide();
                $('.saveOfferBackgroundImage').text("Update changes");
                $('#offer_background_image_modal').modal('show');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    /* when delete button clicked */
    $("body").on('click','.offer-background-image-delete', function(e){
        e.preventDefault();
        offer_background_image_id  = $(this).attr('data-offer-background-image-id');
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
                    url:"{{URL::to('easy-hostel/offer-background-image/delete')}}" + "/" + offer_background_image_id,
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
                                title: 'Offer Background Image Deleted successfully'
                            });
                            offer_background_image_table.ajax.reload();
                            setInterval(function(){ 
                                location.reload();
                            }, 1000);
                            
                            
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
        $('#offerbackgroundimageForm')[0].reset();
        $("#offerbackgroundimageForm").validate().resetForm();
        $("div .modal-footer").show();
        $("div .custom-file").show();
        $('#offer_background_preview_image').attr('src', '');
    })
});
</script>
@endsection