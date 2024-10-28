@extends('admin.layout.master')
@section('css')
<style>

</style>
@endsection
@section('content')
<div class="card" style="width: 100%">
    <div class="card-header">
        <h4 class="m-0 font-weight-bold text-primary">
        Hostel Owner Table 
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <table class="stripe" id="tbl_hostelowner">
                    <thead class="thead-light">
                        <tr>
                            <th>S.N.</th>
                            <th>Owner Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Hostel Name</th>
                            <th>Hostel Address</th>
                            <th>Status</th>
                            
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
    <div class="modal fade" id="hostelowner_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" name="hostelOwnerForm" id="hostelOwnerForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="hostelowner-id"  value="">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><b>Owner Name</b></label>
                            <input type="text" name="title" class="form-control title" disabled>
                        </div>
                        <div class="col-md-6">
                            <label><b>Address</b></label>
                            <input type="text" name="address" class="form-control address" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><b>Phone</b></label>
                            <input type="text" name="phone" class="form-control phone" disabled>
                        </div>
                        <div class="col-md-6">
                                <label><b>Hostel Name</b></label>
                                <input type="text" name="hostelname" class="form-control hostelname" disabled>
                            </div>
                    </div>
                    <div class="form-group row">
                            <div class="col-md-6">
                                    <label><b>Hostel Address</b></label>
                                    <input type="text" name="hosteladdress" class="form-control hosteladdress" disabled>
                                </div>
                                <div class="col-md-6">
                                        <label><b>Status</b></label>
                                        <select name="status" class="form-control status">
                                            <option value="declined">Declined</option>
                                            <option value="accepted">Accepted</option>
                                        </select>
                                    </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm saveHostelOwner">Update changes</button>
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
    var hostelowner_table = $('#tbl_hostelowner').DataTable({
        dom: 'Bfrtip',
        LengthChange: true,
        "bProcessing": true,
       
        serverSide : true,
        processing : true,
        ajax       : {
                        url  : "{{ route('hostelowner.gethostelowner') }}",
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
              
              {"data" :"ownername" ,        'name' :'ownername'},
              {"data" :"address" ,         'name' :'address'},
              {"data" :"phone" ,        'name' :'phone'},
              {"data" :"hostelname" ,         'name' :'hostelname'},
              {"data" :"hosteladdress" ,         'name' :'hosteladdress'},
              {"data" :"status" ,     'name' :'status'},
             
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

    
    
    /* when save button click */
    $('.saveHostelOwner').click(function(e){
        e.preventDefault();
        
        var hostelowner_id  = $(".hostelowner-id").val();
        uri = "{{ URL::to('/easy-hostel/hostel-owner/update') }}" + "/" + hostelowner_id;
        
        /* form data */
        var result = new FormData($("#hostelOwnerForm")[0]);
        $.ajax({
            data: result,
            url: uri,
            type: "POST",
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                
                if(data.status=='success'){
                    $('#hostelOwnerForm').trigger("reset");
                    $('#hostelowner_modal').modal('hide');
                    // based on store or update method showing alert information
                    
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    Toast.fire({
                        type: 'success',
                        title: 'Hostel Owner Status Updated Successfully'
                    });
                    hostelowner_table.ajax.reload();
                        
                    
                }
                else{
                    swal('Not allowed!!','error');
                }
            },
            error: function (data) {
                swal('Somethings error');
            }
        });
        
    });
    /* when edit button clicked */
    $("body").on('click','.hostelowner-edit', function(e){
        e.preventDefault();
    
        hostelowner_id = $(this).attr('data-hostelowner-id');
        $.ajax({
            url:"{{ URL::to('easy-hostel/hostel-owner/edit') }}" + "/" + hostelowner_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                // console.log(data.result.description)
                if(data.status == "success"){
                    $('.modal-title').text("Update Hostel Owner Status");
                    $('.hostelowner-id').val(data.result.id);
                    $('.title').val(data.result.name);
                    $('.address').val(data.result.address);
                    $('.phone').val(data.result.phone);
                    $('.hostelname').val(data.result.hostel_name);
                    $('.hosteladdress').val(data.result.hostel_address);
                    $('.status').val(data.result.status);
                    
                    $('.saveHostelOwner').text("Update changes");
                    $('#hostelowner_modal').modal('show');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
   


    /* reset form field when modal closed */
    $('.modal').on('hidden.bs.modal', function () {
        $('#hostelOwnerForm')[0].reset();
        $("#hostelOwnerForm").validate().resetForm();
        
    })
});
</script>
@endsection