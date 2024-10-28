@extends('admin.layout.master')
@section('css')
<style>
i.form-control.text-center.fa-2x.add_more {
    background-color: #020afb;
    color: black;
    font-weight: 900;
    cursor: pointer;
}
i.form-control.text-center.fa-2x.minus_more {
    background-color: red;
    color: black;
    font-weight: 900;
    cursor: pointer;
}
.modal-body{
   
}




</style>
@endsection
@section('content')
<div class="card" style="width: 100%">
    <div class="card-header">
        <h4 class="m-0 font-weight-bold text-primary">
        <a href="javascript:void(0)" type="button" class="btn btn-default btn-sm add-hostel-price">add new hostel price</a>
        Services Table 
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <table class="stripe" id="tbl_hostel_price">
                    <thead class="thead-light">
                        <tr>
                            <th>S.N.</th>
                            <th>Hostel</th>
                            <th>Room Type</th>
                            <th>Availabel Room</th>
                            <th>Pricing</th>
                                              
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
    <div class="modal fade" id="hostel_price_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" name="hostelpriceForm" id="hostelpriceForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="hostel-price-id"  value="">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label><b>Hostel</b></label>
                            <select name="hostel" class="form-control hostel" data-msg="Please select hostel"  id="hostel" required>
                                
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label><b>Room Type</b></label>
                            <select name="room_type" class="form-control room_type" data-msg="Please select room type " required>
                                <option selected disabled>Select room type </option>
                                <option value="single">single</option>
                                <option value="shared(2)">shared(2)</option>
                                <option value="shared(3)">shared(3)</option>
                                <option value="shared(4)">shared(4)</option>
                                <option value="shared(5)">shared(5)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label><b>Available Room</b></label>
                            <input type="number" name="available_room" class="form-control available_room"   required>
                        </div>
                        
                    </div>
                    <div class="form-group main-div">
                        {{-- <div class="row">
                            <div class="col-md-6"><label><b>Pricing Type</b></label>
                                <select name="pricing" class="form-control pricing" data-msg="Please select pricing type " required>
                                    <option selected disabled>Select pricing type </option>
                                    <option value="1 month">1 month</option>
                                    <option value="3 months">3 months</option>
                                    <option value="6 months">6 months</option>
                                    <option value="1 years">1 years</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label><b>Price</b></label>
                                <input type="number" name="price" class="form-control price"  placeholder="Price" required>
                            </div>
                            
                        </div> --}}
                    </div>
                   
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm saveHostelPrice">Save changes</button>
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
    /* while add more button click */
    
    $(document).on('click',".add_more",function(e){
        e.preventDefault()
        $(".main-div").append('<div class="row"><div class="col-md-4"><label><b>Pricing Type</b></label><select name="pricing[]" class="form-control pricing" data-msg="Please select pricing type " required><option selected disabled>Select pricing type </option><option value="1 month">1 month</option><option value="3 months">3 months</option><option value="6 months">6 months</option><option value="1 years">1 years</option></select></div><div class="col-md-4"><label><b>Price</b></label><input type="number" name="price[]" class="form-control price"  placeholder="Price" required></div><div class="col-md-4"><div class="pricing_add_more"><label><b>Remove</b></label><br><i class="form-control text-center fa-2x minus_more">remove</i></div></div></div>')
    });
    $(".main-div").on("click",".minus_more", function(e){ 
        e.preventDefault();
		$(this).parent('div').parent('div').parent('div').remove(); //remove input field
		
    })
    /* datatable */
    var hostel_price_table = $('#tbl_hostel_price').DataTable({
        dom: 'Bfrtip',
        LengthChange: true,
        "bProcessing": true,
        
        serverSide : true,
        processing : true,
        ajax       : {
                        url  : "{{ route('hostelprice.gethostelprice') }}",
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
              {"data" :"hostel" ,       'name' :'hostel'},
              {"data" :"room_type" ,    'name' :'room_type'},
              {"data" :"available_room",'name' :'available_room'},
              {"data" :"pricing" ,      'name' :'pricing'},
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
    $('.add-hostel-price').on('click',function(e){
        e.preventDefault();
        save_method = "add";
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
        $('.minus_more').parent('div').parent('div').parent('div').remove();
        $(".main-div").append('<div class="row"><div class="col-md-4"><label><b>Pricing Type</b></label><select name="pricing[]" class="form-control pricing" data-msg="Please select pricing type " required><option selected disabled>Select pricing type </option><option value="1 month">1 month</option><option value="3 months">3 months</option><option value="6 months">6 months</option><option value="1 years">1 years</option></select></div><div class="col-md-4"><label><b>Price</b></label><input type="number" name="price[]" class="form-control price"  placeholder="Price" required></div><div class="col-md-4"><div class="pricing_add_more"><label><b>add more</b></label><br><i class="form-control text-center fa-2x add_more">add more</i></div></div></div>')
        
        $('.modal-title').text('Hostel Price Add Form');
        $('.saveHostelPrice').text('Save changes');
        $('#hostel_price_modal').modal('show');
    });
    /* form validaion */
    var validator = $("#hostelpriceForm").validate({
        rules: {
            hostel: {
                required: true,
            },
            room_type: {
                required: true,
            },
            pricing: {
                required: true,
            },
            price: {
                required: true,
            },
            
        }
    });
    /* when save button click */
    $('.saveHostelPrice').click(function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        if($('#hostelpriceForm').valid()){
        /* check adding new data or updating existing data  */
        if(save_method == 'add')
        {
            uri = "{{route('hostelprice.store')}}";
        }
        else{
            var hostel_price_id  = $(".hostel-price-id").val();
            uri = "{{ URL::to('/easy-hostel/hostel-price/update') }}" + "/" + hostel_price_id;
        }
        /* form data */
        var result = new FormData($("#hostelpriceForm")[0]);
        $.ajax({
            data: result,
            url: uri,
            type: "POST",
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                
                if(data.status=='success'){
                    $('#hostelpriceForm').trigger("reset");
                    $('#hostel_price_modal').modal('hide');
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
                            title: 'Hostel Price Added Successfully'
                        });
                        hostel_price_table.ajax.reload();
                        
                    }else{
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'Hostel Price Updated successfully'
                        });
                        hostel_price_table.ajax.reload();
                        
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
    $("body").on('click','.hostel-price-edit', function(e){
        e.preventDefault();
       
        save_method = "edit";
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
        
        hostel_price_id = $(this).attr('data-hostel-price-id');
        $.ajax({
            url:"{{ URL::to('easy-hostel/hostel-price/edit') }}" + "/" + hostel_price_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                console.log(data.result)
                if(data.status == "success"){
                    $('.modal-title').text("Update Hostel Price");
                    $('.hostel-price-id').val(data.result.id);
                    
                    $('.hostel').val(data.result.hostel_id);
                    $('.room_type').val(data.result.room_type);
                    $('.available_room').val(data.result.available_room);
                    /* show all  pricing */

                    $('.add_more').parent('div').parent('div').parent('div').remove();
                    $.each(jQuery.parseJSON(data.result.pricing), function(i, item) {
                    // console.log('this is pricing ::',i,item)
                        $(".main-div").append('<div class="row"><div class="col-md-4"><label><b>Pricing Type</b></label><select name="pricing[]" class="form-control pricing" data-msg="Please select pricing type " required><option selected disabled>Select pricing type </option><option value="1 month" '+ ((i == "1 month") ? "selected" : "") +'>1 month</option><option value="3 months" '+ ((i == "3 months") ? "selected" : "") +'>3 months</option><option value="6 months" '+ ((i == "6 months") ? "selected" : "") +'>6 months</option><option value="1 years" '+ ((i == "1 years") ? "selected" : "") +'>1 years</option></select></div><div class="col-md-4"><label><b>Price</b></label><input type="number" name="price[]" class="form-control price"  placeholder="Price" value="'+ item +'" required></div><div class="col-md-4"><div class="pricing_add_more"><label><b>Add More</b></label><br><i class="form-control text-center fa-2x add_more">add more</i></div></div></div>');
                    });
                    
                    
                    $('.saveHostelPrice').text("Update changes");
                    $('#hostel_price_modal').modal('show');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    /* when delete button clicked */
    $("body").on('click','.hostel-price-delete', function(e){
        e.preventDefault();
        hostel_price_id  = $(this).attr('data-hostel-price-id');
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
                    url:"{{URL::to('easy-hostel/hostel-price/delete')}}" + "/" + hostel_price_id,
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
                                title: 'Hostel Price Deleted successfully'
                            });
                            hostel_price_table.ajax.reload();
                            
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
        $('#hostelpriceForm')[0].reset();
        $("#hostelpriceForm").validate().resetForm();
        $('.minus_more').parent('div').parent('div').parent('div').remove();
        $('.add_more').parent('div').parent('div').parent('div').remove();
        $("div .modal-footer").show();
       
    })
});
</script>
@endsection