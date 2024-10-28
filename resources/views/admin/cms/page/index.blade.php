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
#page_preview_image{
    margin-top:5px;
}
#page_background_preview_image{
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
        <a href="javascript:void(0)" type="button" class="btn btn-default btn-sm add-page">add new page</a>
        Page Table 
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <table class="stripe" id="tbl_page">
                    <thead class="thead-light">
                        <tr>
                            <th>S.N.</th>
                            <th>Image</th>
                            <th>Background Image</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Sub Title</th>
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
    <div class="modal fade" id="page_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" name="pageForm" id="pageForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="page-id"  value="">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control title"  required data-rule-minlength="4"  data-msg-minlength="At least four character" data-msg="Title  shouldn't be empty">
                        </div>
                        <div class="col-md-6">
                            <label>Sub Title</label>
                            <input type="text" name="subtitle" class="form-control subtitle">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="image">Image</label>
                            <div id="upload_prev">
                                <img id="page_preview_image" src="" width="100%" height="200" />
                            </div>
                            <div class="custom-file overflow-hidden rounded-pill">
                                <input id="customFile" type="file" class="custom-file-input rounded-pill image" name="image">
                                    
                                <label for="customFile" class="custom-file-label rounded-pill">Choose file</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="image">Background Image</label>
                            <div id="upload_prev">
                                <img id="page_background_preview_image" src="" width="100%" height="200" />
                            </div>
                            <div class="custom-file overflow-hidden rounded-pill">
                                <input id="customFile1" type="file" class="custom-file-input rounded-pill image" name="background_image">
                                    
                                <label for="customFile" class="custom-file-label rounded-pill">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Description</label>
                            <textarea name="description" class="form-control description"  placeholder="Description" required></textarea>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm savePage">Save changes</button>
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
    var page_table = $('#tbl_page').DataTable({
        dom: 'Bfrtip',
        LengthChange: true,
        "bProcessing": true,
        
        serverSide : true,
        processing : true,
        ajax       : {
                        url  : "{{ route('page.getpage') }}",
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
              {'render'  :function(data, type, JsonResultRow, meta)
                {
                    return "<img src='"+ JsonResultRow.background_image + "' height='100px' width='150'>";
                }
              },
              {"data" :"title" ,       'name' :'title'},
              {"data" :"slug" ,       'name' :'slug'},
              {"data" :"subtitle" ,       'name' :'subtitle'},
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
        readURL(this, 'page_preview_image');
    });
    function readURL(input1, id1) {
        if (input1.files && input1.files[0]) {
            var reader1 = new FileReader();

            reader1.onload = function (e) {
                $('#' + id1).attr('src', e.target.result);
            }

            reader1.readAsDataURL(input1.files[0]);
        }
    }
    $("#customFile1").change(function () {
        readURL(this, 'page_background_preview_image');
    });
    /* csrf token setup */
    var uri,save_method;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* when add button click */
    $('.add-page').on('click',function(e){
        e.preventDefault();
        save_method = "add";
        $('.modal-title').text('Page Add Form');
        $('.savePage').text('Save changes');
        $('#page_modal').modal('show');
    });
    /* form validaion */
    var validator = $("#pageForm").validate({
        rules: {
            title: {
                required: true,
            },
            date: {
                required: true,
            },
            image: {
                required: false,
            },
            background_image: {
                required: false,
            }
        }
    });
    /* when save button click */
    $('.savePage').click(function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        if($('#pageForm').valid()){
        /* check adding new data or updating existing data  */
        if(save_method == 'add')
        {
            uri = "{{route('page.store')}}";
        }
        else{
            var page_id  = $(".page-id").val();
            uri = "{{ URL::to('/easy-hostel/page/update') }}" + "/" + page_id;
        }
        /* form data */
        var result = new FormData($("#pageForm")[0]);
        $.ajax({
            data: result,
            url: uri,
            type: "POST",
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                
                if(data.status=='success'){
                    $('#pageForm').trigger("reset");
                    $('#page_modal').modal('hide');
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
                            title: 'Page Added Successfully'
                        });
                        page_table.ajax.reload();
                        
                    }else{
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'Page Updated successfully'
                        });
                        page_table.ajax.reload();
                        
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
    $("body").on('click','.page-edit', function(e){
        e.preventDefault();
       
        save_method = "edit";
        page_id = $(this).attr('data-page-id');
        $.ajax({
            url:"{{ URL::to('easy-hostel/page/edit') }}" + "/" + page_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                // console.log(data.result.description)
                if(data.status == "success"){
                    $('.modal-title').text("Update Blog");
                    $('.page-id').val(data.result.id);
                    $('.title').val(data.result.title);
                    $('.subtitle').val(data.result.subtitle);

                    if(data.result.description){
                        tinyMCE.activeEditor.setContent(data.result.description);
                        $('.description').val(data.result.description);
                    }

                    var image="{{asset('/uploads/pages')}}" + "/" +data.result.image;
                    $("#page_preview_image").attr('src',image);

                    var background_image="{{asset('/uploads/pages')}}" + "/" +data.result.background_image;
                    $("#page_background_preview_image").attr('src',background_image);
                    
                    $('.savePage').text("Update changes");
                    $('#page_modal').modal('show');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    /* when delete button clicked */
    $("body").on('click','.page-delete', function(e){
        e.preventDefault();
        page_id  = $(this).attr('data-page-id');
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
                    url:"{{URL::to('easy-hostel/page/delete')}}" + "/" + page_id,
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
                                title: 'Page Deleted successfully'
                            });
                            page_table.ajax.reload();
                            
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
        $('#pageForm')[0].reset();
        $("#pageForm").validate().resetForm();
        // $("div .modal-footer").show();
        // $("div .custom-file").show();
        $('#page_preview_image').attr('src', '');
        $('#page_background_preview_image').attr('src', '');
    })
});
</script>
@endsection