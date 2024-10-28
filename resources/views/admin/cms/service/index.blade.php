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
#service_preview_image{
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
        <a href="javascript:void(0)" type="button" class="btn btn-default btn-sm add-service">add new service</a>
        Services Table 
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <table class="stripe" id="tbl_service">
                    <thead class="thead-light">
                        <tr>
                            <th>S.N.</th>
                            <th>Icon</th>
                            <th>Title</th>
                            <th>Show On Front</th>
                            <th>Description</th>                           
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
    <div class="modal fade" id="service_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" name="serviceForm" id="serviceForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="service-id"  value="">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control title"  placeholder="Title" required data-rule-minlength="4"  data-msg-minlength="At least four character" data-msg="Service name shouldn't be empty">
                                </div>
                                    
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Show On Front</label>
                                    <select name="show_on_front" class="form-control show_on_front" data-msg="Please select show on front" required>
                                        <option selected disabled>Select show on front</option>
                                        <option value="yes">yes</option>
                                        <option value="no">no</option>
                                    </select>
                                </div>
                                        
                            </div>
                            <div class="row">
                                    
                                <div class="col-md-12">
                                    <label for="image">Image</label>
                                    <div id="upload_prev">
                                        <img id="service_preview_image" src="" width="100%" height="200" />
                                    </div>
                                    <div class="custom-file overflow-hidden rounded-pill">
                                        <input id="customFile" type="file" class="custom-file-input rounded-pill image" name="image">
                                            
                                        <label for="customFile" class="custom-file-label rounded-pill">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control description"  placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm saveService">Save changes</button>
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
    var logo_table = $('#tbl_service').DataTable({
        dom: 'Bfrtip',
        LengthChange: true,
        "bProcessing": true,
        
        serverSide : true,
        processing : true,
        ajax       : {
                        url  : "{{ route('service.getservice') }}",
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
              {"data" :"title" ,       'name' :'title'},
              {"data" :"show_on_front" ,       'name' :'show_on_front'},
              {"data" :"description" ,       'name' :'description'},
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
        readURL(this, 'service_preview_image');
    });
    /* csrf token setup */
    var uri,save_method;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* when add button click */
    $('.add-service').on('click',function(e){
        e.preventDefault();
        save_method = "add";
        $('.modal-title').text('Service Add Form');
        $('.saveService').text('Save changes');
        $('#service_modal').modal('show');
    });
    /* form validaion */
    var validator = $("#serviceForm").validate({
        rules: {
            title: {
                required: true,
            },
            show_on_front: {
                required: true,
            },
            image: {
                required: false,
            }
        }
    });
    /* when save button click */
    $('.saveService').click(function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        if($('#serviceForm').valid()){
        /* check adding new data or updating existing data  */
        if(save_method == 'add')
        {
            uri = "{{route('service.store')}}";
        }
        else{
            var service_id  = $(".service-id").val();
            uri = "{{ URL::to('/easy-hostel/service/update') }}" + "/" + service_id;
        }
        /* form data */
        var result = new FormData($("#serviceForm")[0]);
        $.ajax({
            data: result,
            url: uri,
            type: "POST",
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                
                if(data.status=='success'){
                    $('#serviceForm').trigger("reset");
                    $('#service_modal').modal('hide');
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
                            title: 'Service Added Successfully'
                        });
                        logo_table.ajax.reload();
                        
                    }else{
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'Service Updated successfully'
                        });
                        logo_table.ajax.reload();
                        
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
    $("body").on('click','.service-edit', function(e){
        e.preventDefault();
       
        save_method = "edit";
        service_id = $(this).attr('data-service-id');
        $.ajax({
            url:"{{ URL::to('easy-hostel/service/edit') }}" + "/" + service_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                // console.log(data.result.description)
                if(data.status == "success"){
                    $('.modal-title').text("Update Service");
                    $('.service-id').val(data.result.id);
                    $('.title').val(data.result.title);
                    $('.show_on_front').val(data.result.show_on_front);
                    if(data.result.description){
                        tinyMCE.activeEditor.setContent(data.result.description);
                        $('.description').val(data.result.description);
                    }

                    var image="{{asset('/uploads/services')}}" + "/" +data.result.image;
                    $("#service_preview_image").attr('src',image);
                    
                    $('.saveService').text("Update changes");
                    $('#service_modal').modal('show');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    /* when delete button clicked */
    $("body").on('click','.service-delete', function(e){
        e.preventDefault();
        service_id  = $(this).attr('data-service-id');
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
                    url:"{{URL::to('easy-hostel/service/delete')}}" + "/" + service_id,
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
                                title: 'Service Deleted successfully'
                            });
                            logo_table.ajax.reload();
                            
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
        $('#serviceForm')[0].reset();
        $("#serviceForm").validate().resetForm();
        $("div .modal-footer").show();
        $("div .custom-file").show();
        $('#service_preview_image').attr('src', '');
    })
});
</script>
@endsection