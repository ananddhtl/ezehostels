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
#social_preview_image{
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
   
}




</style>
@endsection
@section('content')
<div class="card" style="width: 100%">
    <div class="card-header">
        <h4 class="m-0 font-weight-bold text-primary">
        <a href="javascript:void(0)" type="button" class="btn btn-default btn-sm add-social">add new social media</a>
        Socail Media Table 
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <table class="stripe" id="tbl_social">
                    <thead class="thead-light">
                        <tr>
                            <th>S.N.</th>
                            <th>Icon</th>
                            <th>Title</th>
                            <th>URL</th>                       
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
    <div class="modal fade" id="social_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" name="socialForm" id="socialForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="social-id"  value="">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control title"  placeholder="Title" required data-rule-minlength="4"  data-msg-minlength="At least four character" data-msg="Social media name shouldn't be empty">
                                </div>
                                    
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>URL</label>
                                    <input type="text" name="url" class="form-control url"  placeholder="Url" required  data-msg="Social medai url shouldn't be empty" data-msg-url="Please provide a valid url">
                                </div>
                                        
                            </div>
                            <div class="row">
                                    
                                <div class="col-md-12">
                                    <label for="image">Image</label>
                                    <div id="upload_prev">
                                        <img id="social_preview_image" src="" width="100%" height="200" />
                                    </div>
                                    <div class="custom-file overflow-hidden rounded-pill">
                                        <input id="customFile" type="file" class="custom-file-input rounded-pill image" name="image">
                                            
                                        <label for="customFile" class="custom-file-label rounded-pill">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm saveSocial">Save changes</button>
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
    var social_table = $('#tbl_social').DataTable({
        dom: 'Bfrtip',
        LengthChange: true,
        "bProcessing": true,
        
        serverSide : true,
        processing : true,
        ajax       : {
                        url  : "{{ route('social.getsocial') }}",
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
                    return "<img src='"+ JsonResultRow.image + "' height='100px' width='100'>";
                }
              },
              {"data" :"title" ,       'name' :'title'},
              {"data" :"url" ,       'name' :'url'},
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
        readURL(this, 'social_preview_image');
    });
    /* csrf token setup */
    var uri,save_method;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* when add button click */
    $('.add-social').on('click',function(e){
        e.preventDefault();
        save_method = "add";
        $('.modal-title').text('Service Add Form');
        $('.saveSocial').text('Save changes');
        $('#social_modal').modal('show');
    });
    /* form validaion */
    var validator = $("#socialForm").validate({
        rules: {
            title: {
                required: true,
            },
            url: {
                required: true,
            },
            image: {
                required: false,
            }
        }
    });
    /* when save button click */
    $('.saveSocial').click(function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        if($('#socialForm').valid()){
        /* check adding new data or updating existing data  */
        if(save_method == 'add')
        {
            uri = "{{route('social.store')}}";
        }
        else{
            var social_id  = $(".social-id").val();
            uri = "{{ URL::to('/easy-hostel/social/update') }}" + "/" + social_id;
        }
        /* form data */
        var result = new FormData($("#socialForm")[0]);
        $.ajax({
            data: result,
            url: uri,
            type: "POST",
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                
                if(data.status=='success'){
                    $('#socialForm').trigger("reset");
                    $('#social_modal').modal('hide');
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
                            title: 'Social Added Successfully'
                        });
                        social_table.ajax.reload();
                        
                    }else{
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'Social Updated successfully'
                        });
                        social_table.ajax.reload();
                        
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
    $("body").on('click','.social-edit', function(e){
        e.preventDefault();
       
        save_method = "edit";
        social_id = $(this).attr('data-social-id');
        $.ajax({
            url:"{{ URL::to('easy-hostel/social/edit') }}" + "/" + social_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                // console.log(data.result.description)
                if(data.status == "success"){
                    $('.modal-title').text("Update Service");
                    $('.social-id').val(data.result.id);
                    $('.title').val(data.result.title);
                    $('.url').val(data.result.url);
                    

                    var image="{{asset('/uploads/socials')}}" + "/" +data.result.image;
                    $("#social_preview_image").attr('src',image);
                    
                    $('.saveSocial').text("Update changes");
                    $('#social_modal').modal('show');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    /* when delete button clicked */
    $("body").on('click','.social-delete', function(e){
        e.preventDefault();
        social_id  = $(this).attr('data-social-id');
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
                    url:"{{URL::to('easy-hostel/social/delete')}}" + "/" + social_id,
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
                                title: 'Social Deleted successfully'
                            });
                            social_table.ajax.reload();
                            
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
        $('#socialForm')[0].reset();
        $("#socialForm").validate().resetForm();
        $('#social_preview_image').attr('src', '');
    })
});
</script>
@endsection