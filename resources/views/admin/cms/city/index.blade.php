@extends('admin.layout.master')
@section('css')
<style>
.add_more_city {
    margin-top: 37px;
}
.minus_more_city{
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
        <a href="javascript:void(0)" type="button" class="btn btn-default btn-sm add-city">add new city</a>
        City  Table 
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <table class="stripe" id="tbl_city">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">S.N.</th>
                            <th scope="col">City Name</th>   
                            <th scope="col">Show On Front</th>                        
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
    <div class="modal fade" id="city_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" name="cityForm" id="cityForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="city-id"  value="">
                    <div class="form-group city-main-div">
                        <div class="row">
                            <div class="col-md-10 col10">
                                <label>City</label>
                                <input type="text" name="city[]" class="form-control city"  placeholder="city" required data-rule-minlength="4"  data-msg-minlength="At least four character" data-msg="City name shouldn't be empty">
                            </div>
                            <div class="col-md-2 add">
                                {{-- <label for="city">more</label> --}}
                                <i class="fa fa-plus-square fa-2x add_more_city"></i>
                            </div>
                        </div>
                        <div class="row show_front">
                            <div class="col-md-12 col12">
                                <label>Show On Front</label>
                                <select name="show_on_front" id="show_on_front" class="form-control show_on_front">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm saveCity">Save changes</button>
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
    $(document).on('click',".add_more_city",function(e){
        e.preventDefault()
        $(".city-main-div").append('<div class="row"><div class="col-md-10"><label>City</label><input type="text" name="city[]" class="form-control city"  placeholder="city"></div><div class="col-md-2"><i class="fa fa-minus-square fa-2x minus_more_city"></i></div></div>');
        //alert('i am clicked')
    });
    //when city minus button click
    $(".city-main-div").on("click",".minus_more_city", function(e){ 
        e.preventDefault();
		$(this).parent('div').parent('div').remove(); //remove inout field
		
    })


    /* datatable */
    var city_table = $('#tbl_city').DataTable({
        dom: 'Bfrtip',
        LengthChange: true,
        "bProcessing": true,
        serverSide : true,
        processing : true,
        ajax       : {
                        url  : "{{ route('city.getcity') }}",
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
              {"data" :"title" ,       'name' :'title'},
              {"data" :"show_on_front" ,       'name' :'show_on_front'},
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
    $('.add-city').on('click',function(e){
        e.preventDefault();
        save_method = "add";
        $('.modal-title').text('City Add Form');
        $('div .show_front').hide();
        $('.saveCity').text('Save changes');
        $('#city_modal').modal('show');
    });
    /* form validaion */
    var validator = $("#cityForm").validate({
        rules: {
            city: {
                required: true,
                minlength:4
            }
        }
    });
    /* when save button click */
    $('.saveCity').click(function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        if($('#cityForm').valid()){
        /* check adding new data or updating existing data  */
        if(save_method == 'add')
        {
            uri = "{{route('city.store')}}";
        }
        else{
            var city_id  = $(".city-id").val();
            uri = "{{ URL::to('/easy-hostel/city/update') }}" + "/" + city_id;
        }
        /* form data */
        var result = new FormData($("#cityForm")[0]);
        $.ajax({
            data: result,
            url: uri,
            type: "POST",
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                
                if(data.status=='success'){
                    $('#cityForm').trigger("reset");
                    $('#city_modal').modal('hide');
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
                            title: 'City Added Successfully'
                        });
                        city_table.ajax.reload();
                        
                    }else{
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'City Updated successfully'
                        });
                        city_table.ajax.reload();
                        
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
    $("body").on('click','.city-edit', function(e){
        e.preventDefault();
       
        save_method = "edit";
        city_id = $(this).attr('data-city-id');
        $.ajax({
            url:"{{ URL::to('easy-hostel/city/edit') }}" + "/" + city_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                $('.modal-title').text("Update City");
                $('.city-id').val(data.result.id);
                $('.city').val(data.result.title);
                $('div .show_front').show();
                $('.show_on_front').val(data.result.show_on_front);
                $('div .add').hide();
                $('div .col10').addClass("col-md-12");
                $('.saveCity').text("Update changes");
                $('#city_modal').modal('show');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    /* when delete button clicked */
    $("body").on('click','.city-delete', function(e){
        e.preventDefault();
        city_id  = $(this).attr('data-city-id');
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
                    url:"{{URL::to('easy-hostel/city/delete')}}" + "/" + city_id,
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
                                title: 'City Deleted successfully'
                            });
                            city_table.ajax.reload();
                            
                            
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
        $('#cityForm')[0].reset();
        $("#cityForm").validate().resetForm();
        $('div .add').show();
        $('div .show_front').hide();
        $(".minus_more_city").parent('div').parent('div').remove();
        $('div .col10').removeClass("col-md-12");
        $("div .modal-footer").show();
    })
});
</script>
@endsection