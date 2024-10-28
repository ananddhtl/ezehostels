@extends('admin.layout.master')
@section('css')
<style>

.modal-body{
   
}

</style>
@endsection
@section('content')
<div class="card" style="width: 100%">
    <div class="card-header">
        <h4 class="m-0 font-weight-bold text-primary">
        @if($site_contact->count() == 0)
        <a href="javascript:void(0)" type="button" class="btn btn-default btn-sm add-site-contact">add new site contact</a>
        @endif
        Site Contact  Table 
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <table class="stripe" id="tbl_site_contact">
                    <thead class="thead-light">
                        <tr>
                            <th>S.N.</th>
                            <th>Phone1</th>
                            <th>Phone2</th>
                            <th>Email</th>
                            <th>Address</th>                       
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
    <div class="modal fade" id="site_contact_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" name="sitecontactForm" id="sitecontactForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="site-contact-id"  value="">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                        <label>Phone1</label>
                                        <input type="text" name="phone1" class="form-control phone1"  placeholder="Phone1" required data-rule-minlength="10" data-rule-maxlength="10"  data-msg-minlength="At least ten character" data-msg-maxlength="Max ten character" data-msg="Phone1 shouldn't be empty">
                                </div>
                                    
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Phone2</label>
                                        <input type="text" name="phone2" class="form-control phone2"  placeholder="Phone2" data-rule-minlength="10" data-rule-maxlength="10"  data-msg-minlength="At least ten character" data-msg-maxlength="Max ten character">
                                </div>
                                        
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                        <label>Email</label>
                                        <input type="text" name="email" class="form-control email"  placeholder="Email" required   data-msg-email="please provide a valid email" data-msg="email shouldn't be empty">
                                </div>
                                    
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Address</label>
                                        <input type="text" name="address" class="form-control address"  placeholder="Address" required   data-msg="address shouldn't be empty">
                                </div>
                                        
                            </div>
                        </div>
                        
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm saveSiteContact">Save changes</button>
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
    var site_contact_table = $('#tbl_site_contact').DataTable({
        dom: 'Bfrtip',
        LengthChange: true,
        "bProcessing": true,
        
        serverSide : true,
        processing : true,
        ajax       : {
                        url  : "{{ route('sitecontact.getsitecontact') }}",
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
              
              {"data" :"phone1" ,       'name' :'phone1'},
              {"data" :"phone2" ,       'name' :'phone2'},
              {"data" :"email" ,       'name' :'email'},
              {"data" :"address" ,       'name' :'address'},
              {"data" :"action" ,       'name' :'action'},
          
        ]
    });//end of datatable
   
    /* csrf token setup */
    var uri,save_method;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* when add button click */
    $('.add-site-contact').on('click',function(e){
        e.preventDefault();
        save_method = "add";
        $('.modal-title').text('Site Contact Add Form');
        $('.saveSiteContact').text('Save changes');
        $('#site_contact_modal').modal('show');
    });
    /* form validaion */
    var validator = $("#sitecontactForm").validate({
        rules: {
            phone1: {
                required: true,
                
            },
            email: {
                required: true,
            },
            address: {
                required: true,
            }
        }
    });
    /* when save button click */
    $('.saveSiteContact').click(function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        if($('#sitecontactForm').valid()){
        /* check adding new data or updating existing data  */
        if(save_method == 'add')
        {
            uri = "{{route('sitecontact.store')}}";
        }
        else{
            var site_contact_id  = $(".site-contact-id").val();
            uri = "{{ URL::to('/easy-hostel/site-contact/update') }}" + "/" + site_contact_id;
        }
        /* form data */
        var result = new FormData($("#sitecontactForm")[0]);
        $.ajax({
            data: result,
            url: uri,
            type: "POST",
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                
                if(data.status=='success'){
                    $('#sitecontactForm').trigger("reset");
                    $('#site_contact_modal').modal('hide');
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
                            title: 'Site Contact Added Successfully'
                        });
                        site_contact_table.ajax.reload();
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
                            title: 'Site Contact Updated successfully'
                        });
                        site_contact_table.ajax.reload();
                        
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
    $("body").on('click','.site-contact-edit', function(e){
        e.preventDefault();
       
        save_method = "edit";
        site_contact_id = $(this).attr('data-site-contact-id');
        $.ajax({
            url:"{{ URL::to('easy-hostel/site-contact/edit') }}" + "/" + site_contact_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                // console.log(data.result.description)
                if(data.status == "success"){
                    $('.modal-title').text("Update Service");
                    $('.site-contact-id').val(data.result.id);
                    $('.phone1').val(data.result.phone1);
                    $('.phone2').val(data.result.phone2);
                    $('.email').val(data.result.email);
                    $('.address').val(data.result.address);

                   
                    
                    $('.saveSiteContact').text("Update changes");
                    $('#site_contact_modal').modal('show');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    /* when delete button clicked */
    $("body").on('click','.site-contact-delete', function(e){
        e.preventDefault();
        site_contact_id  = $(this).attr('data-site-contact-id');
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
                    url:"{{URL::to('easy-hostel/site-contact/delete')}}" + "/" + site_contact_id,
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
                                title: 'Site Contact Deleted successfully'
                            });
                            site_contact_table.ajax.reload();
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
        $('#sitecontactForm')[0].reset();
        $("#sitecontactForm").validate().resetForm();
        $('#social_preview_image').attr('src', '');
    })
});
</script>
@endsection