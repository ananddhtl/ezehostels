@extends('admin.layout.master')
@section('css')
<style>
.add_more_place {
    margin-top: 37px;
}
.minus_more_place{
    margin-top: 37px;
}
.modal-body{
    padding-top: 0px;
    padding-bottom: 0px;
}


</style>
@endsection
@section('content')
<div class="card" style="width: 100%">
    <div class="card-header">
        <h4 class="m-0 font-weight-bold text-primary">
        <a href="javascript:void(0)" type="button" class="btn btn-default btn-sm add-place">add new city</a>
        Place  Table 
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <table class="stripe" id="tbl_place">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">S.N.</th>
                            <th scope="col">City</th>
                            <th scope="col">Place Name</th>                           
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
    <div class="modal fade" id="place_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" name="placeForm" id="placeForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="place-id"  value="">
                    <div class="form-group place-main-div">
                        <div class="row">
                            <div class="col-md-12">
                                <label>City</label>
                                <select name="city" class="form-control city" required data-msg="Please select city"  id="city">
                                
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col10">
                                <label>Place</label>
                                <input type="text" name="place[]" class="form-control place"  placeholder="place" required data-rule-minlength="4"  data-msg-minlength="At least four character" data-msg="Place name shouldn't be empty">
                            </div>
                            <div class="col-md-2 text-right add">
                                {{-- <label for="city">more</label> --}}
                                <i class="fa fa-plus-square fa-2x add_more_place"></i>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm savePlace">Save changes</button>
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
    /* when city plus button click */
    $(document).on('click',".add_more_place",function(e){
        e.preventDefault()
        $(".place-main-div").append('<div class="row"><div class="col-md-10 col10"><label>Place</label><input type="text" name="place[]" class="form-control place"  placeholder="place"></div><div class="col-md-2"><i class="fa fa-minus-square fa-2x minus_more_place"></i></div></div>');
        //alert('i am clicked')
    });
    //when city minus button click
    $(".place-main-div").on("click",".minus_more_place", function(e){ 
        e.preventDefault();
		$(this).parent('div').parent('div').remove(); //remove inout field
		
    })


    /* datatable */
    var place_table = $('#tbl_place').DataTable({
        dom: 'Bfrtip',
        LengthChange: true,
        "bProcessing": true,
        serverSide : true,
        processing : true,
        ajax       : {
                        url  : "{{ route('place.getplace') }}",
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
              {"data" :"city" ,       'name' :'city'},
              {"data" :"title" ,       'name' :'title'},
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
    $('.add-place').on('click',function(e){
        e.preventDefault();
        save_method = "add";
        $('#city').empty();
        $('#city').prepend('<option disabled="disabled" selected="selected">Please select city</option>');
        $.get("{{URL::to('/easy-hostel/city/getallcity')}}", function(data){
            // console.log(data.result);
            if(data.status == "success"){
                $.each(data.result, function( key, value ) {
                    $('#city').append($('<option>', { 
                            value: value.id,
                            text : value.title,
                    })); 
                });
            }
        });
        $('.modal-title').text('Place Add Form');
        $('.savePlace').text('Save changes');
        $('#place_modal').modal('show');
    });
    /* form validaion */
    var validator = $("#placeForm").validate({
        rules: {
            place: {
                required: true,
                minlength:4
            },
            city:{
                required:true
            }
        }
    });
    /* when save button click */
    $('.savePlace').click(function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        if($('#placeForm').valid()){
        /* check adding new data or updating existing data  */
        if(save_method == 'add')
        {
            uri = "{{route('place.store')}}";
        }
        else{
            var place_id  = $(".place-id").val();
            uri = "{{ URL::to('/easy-hostel/place/update') }}" + "/" + place_id;
        }
        /* form data */
        var result = new FormData($("#placeForm")[0]);
        $.ajax({
            data: result,
            url: uri,
            type: "POST",
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                
                if(data.status=='success'){
                    $('#placeForm').trigger("reset");
                    $('#place_modal').modal('hide');
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
                            title: 'Place Added Successfully'
                        });
                        place_table.ajax.reload();
                        
                    }else{
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'Place Updated successfully'
                        });
                        place_table.ajax.reload();
                        
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
    $("body").on('click','.place-edit', function(e){
        e.preventDefault();
       
        save_method = "edit";
        $('#city').empty();
        $('#city').prepend('<option disabled="disabled" selected="selected">Please select city</option>');
        $.get("{{URL::to('/easy-hostel/city/getallcity')}}", function(data){
            // console.log(data.result);
            if(data.status == "success"){
                $.each(data.result, function( key, value ) {
                    $('#city').append($('<option>', { 
                            value: value.id,
                            text : value.title,
                    })); 
                });
            }
        });
        place_id = $(this).attr('data-place-id');
        $.ajax({
            url:"{{ URL::to('easy-hostel/place/edit') }}" + "/" + place_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                $('.modal-title').text("Update Place");
                $('.place-id').val(data.result.id);
                $('.place').val(data.result.title);
                $('.city').val(data.result.city_id);
                $('div .add').hide();
                
                $('div .col10').addClass("col-md-12");
                $('.savePlace').text("Update changes");
                $('#place_modal').modal('show');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    /* when delete button clicked */
    $("body").on('click','.place-delete', function(e){
        e.preventDefault();
        place_id  = $(this).attr('data-place-id');
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
                    url:"{{URL::to('easy-hostel/place/delete')}}" + "/" + place_id,
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
                                title: 'Place Deleted successfully'
                            });
                            place_table.ajax.reload();
                            
                            
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
        $('#placeForm')[0].reset();
        $("#placeForm").validate().resetForm();
        $('div .add').show();
        $(".minus_more_place").parent('div').parent('div').remove();
        $('div .col10').removeClass("col-md-12");
        $("div .modal-footer").show();
    })
});
</script>
@endsection