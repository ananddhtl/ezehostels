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
#android_preview_image{
    margin-top:5px;
}
#ios_preview_image{
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
        @if($mobapp->count() == 0)
        <a href="javascript:void(0)" type="button" class="btn btn-default btn-sm add-mobile-app">add new </a>
        Mobile App Table 
        </h4>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <table class="stripe" id="tbl_mobileapp">
                    <thead class="thead-light">
                        <tr>
                            <th>S.N.</th>
                            <th>Android Image</th>
                            <th>IOS Image</th>
                            <th>Android URL</th>  
                            <th>IOS URL</th>                       
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
    <div class="modal fade" id="mobileapp_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" name="mobileappForm" id="mobileappForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="mobileapp-id"  value="">
                    <div class="form-group row">
                       <div class="col-md-6">
                            <label>Android URL</label>
                            <input type="text" name="android_url" class="form-control android_url"  placeholder="android_url" required  data-msg="URL shouldn't be empty">
                        </div>
                        <div class="col-md-6">
                            <label>IOS URL</label>
                            <input type="text" name="ios_url" class="form-control ios_url"  placeholder="ios_url" required  data-msg="URL shouldn't be empty">
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        
                         <div class="col-md-6">
                            <label for="image">Android Image</label>
                            <div id="upload_prev">
                                <img id="android_preview_image" src="" width="100%" height="200" />
                            </div>
                            <div class="custom-file overflow-hidden rounded-pill">
                                <input id="customFile" type="file" class="custom-file-input rounded-pill android_image" name="android_image">
                                    
                                <label for="customFile" class="custom-file-label rounded-pill">Choose file</label>
                            </div>
                        </div>
                         <div class="col-md-6">
                             <label for="image">IOS Image</label>
                             <div id="upload_prev">
                                 <img id="ios_preview_image" src="" width="100%" height="200" />
                             </div>
                             <div class="custom-file overflow-hidden rounded-pill">
                                 <input id="customFile1" type="file" class="custom-file-input rounded-pill ios_image" name="ios_image">
                                     
                                 <label for="customFile" class="custom-file-label rounded-pill">Choose file</label>
                             </div>
                         </div>
                     </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm saveMobileapp">Save changes</button>
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
    var mobileapp_table = $('#tbl_mobileapp').DataTable({
        dom: 'Bfrtip',
        LengthChange: true,
        "bProcessing": true,
        
        serverSide : true,
        processing : true,
        ajax       : {
                        url  : "{{ route('mobileapp.getmobileapp') }}",
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
                    return "<img src='"+ JsonResultRow.android_image + "' height='100px' width='100'>";
                }
              },
              {'render'  :function(data, type, JsonResultRow, meta)
                {
                    return "<img src='"+ JsonResultRow.ios_image + "' height='100px' width='100'>";
                }
              },
              {"data" :"android_url" ,       'name' :'android_url'},
              {"data" :"ios_url" ,       'name' :'ios_url'},
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
        readURL(this, 'android_preview_image');
    });
    function readURL1(input1, id1) {
        if (input1.files && input1.files[0]) {
            var reader1 = new FileReader();

            reader1.onload = function (e) {
                $('#' + id1).attr('src', e.target.result);
            }

            reader1.readAsDataURL(input1.files[0]);
        }
    }
    $("#customFile1").change(function () {
        readURL1(this, 'ios_preview_image');
    });
    /* csrf token setup */
    var uri,save_method;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* when add button click */
    $('.add-mobile-app').on('click',function(e){
        e.preventDefault();
        save_method = "add";
        $('.modal-title').text('Mobile App Add Form');
        $('.saveMobileapp').text('Save changes');
        $('#mobileapp_modal').modal('show');
    });
    /* form validaion */
    var validator = $("#mobileappForm").validate({
        rules: {
            android_url: {
                required: true,
            },
            ios_url: {
                required: true,
            },
            android_image: {
                required: false,
            },
            ios_image: {
                required: false,
            }
        }
    });
    /* when save button click */
    $('.saveMobileapp').click(function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        if($('#mobileappForm').valid()){
        /* check adding new data or updating existing data  */
        if(save_method == 'add')
        {
            uri = "{{route('mobileapp.store')}}";
        }
        else{
            var mobileapp_id  = $(".mobileapp-id").val();
            uri = "{{ URL::to('/easy-hostel/mobileapp/update') }}" + "/" + mobileapp_id;
        }
        /* form data */
        var result = new FormData($("#mobileappForm")[0]);
        // console.log(result);
        $.ajax({
            data: result,
            url: uri,
            type: "POST",
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                
                if(data.status=='success'){
                    $('#mobileappForm').trigger("reset");
                    $('#mobileapp_modal').modal('hide');
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
                            title: 'Mobile App Info Added Successfully'
                        });
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
                            title: 'Mobile App Info Updated successfully'
                        });
                        setInterval(function(){ 
                                location.reload();
                        }, 1000);
                        
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
    $("body").on('click','.mobileapp-edit', function(e){
        e.preventDefault();
       
        save_method = "edit";
        mobileapp_id = $(this).attr('data-mobileapp-id');
        $.ajax({
            url:"{{ URL::to('easy-hostel/mobileapp/edit') }}" + "/" + mobileapp_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                // console.log(data.result.description)
                if(data.status == "success"){
                    $('.modal-title').text("Update Mobile App Info");
                    $('.mobileapp-id').val(data.result.id);
                    $('.ios_url').val(data.result.ios_url);
                    $('.android_url').val(data.result.android_url);
                    
                    var android_image="{{asset('/uploads/mobileapp')}}" + "/" +data.result.android_image;
                    $("#android_preview_image").attr('src',android_image);
                    var ios_image="{{asset('/uploads/mobileapp')}}" + "/" +data.result.ios_image;
                    $("#ios_preview_image").attr('src',ios_image);
                    
                    
                    $('.saveMobileapp').text("Update changes");
                    $('#mobileapp_modal').modal('show');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    /* when delete button clicked */
    $("body").on('click','.mobileapp-delete', function(e){
        e.preventDefault();
        mobileapp_id  = $(this).attr('data-mobileapp-id');
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
                    url:"{{URL::to('easy-hostel/mobileapp/delete')}}" + "/" + mobileapp_id,
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
                                title: 'Mobile App Info Deleted successfully'
                            });
                            mobileapp_table.ajax.reload();
                            
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
        $('#mobileappForm')[0].reset();
        $("#mobileappForm").validate().resetForm();
        $('#android_preview_image').attr('src', '');
    })
});
</script>
@endsection