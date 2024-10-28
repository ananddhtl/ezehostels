@extends('admin.layout.master')
@section('css')
<style>

</style>
@endsection
@section('content')
<div class="card" style="width: 100%">
    <div class="card-header">
        <h4 class="m-0 font-weight-bold text-primary">
        <a href="javascript:void(0)" type="button" class="btn btn-default btn-sm add_metakey">add new meta key description</a>
        Meta Key Description Table 
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <table class="stripe" id="tbl_metakey">
                    <thead class="thead-light">
                        <tr>
                            <th>S.N.</th>
                            <th>City</th>
                            <th>Place</th>
                            <th>Hostel</th>
                            <th>Meta Key</th>
                            <th>Meta Description</th> 
                            <th>Search Result Description</th>                          
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
    <div class="modal fade" id="metakey_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" name="metakeyForm" id="metakeyForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="metakey-id"  value="">
                    <div class="form-group row">
                        <div class="col-md-3">
                                <label>Meta Title</label>
                                <input type="text" name="meta_key" class="form-control meta_key" required data-rule-minlength="3"  data-msg-minlength="At least three character" data-msg="I shouldn't be empty">
                        </div>
                        <div class="col-md-3">
                                <label>City</label>
                                <select name="city" id="city" class="form-control city"></select>
                        </div>
                        <div class="col-md-3">
                            <label>Place</label>
                            <select name="place" id="place" class="form-control place"></select>
                        </div>
                        <div class="col-md-3">
                            <label>Hostel</label>
                            <select name="hostel" id="hostel" class="form-control hostel"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="description">Meta Description</label>
                            <textarea name="description" id="description" class="form-control description" required data-msg="please provide meta description"></textarea>
                            <p id="description"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="search_result_description">Search Result Description</label>
                            <textarea name="search_result_description" id="search_result_description" class="form-control search_result_description" required data-msg="please provide meta search_result_description"></textarea>
                            <p id="search_result_description"></p>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm saveMetaKey">Save changes</button>
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
    var logo_table = $('#tbl_metakey').DataTable({
        dom: 'Bfrtip',
        LengthChange: true,
        "bProcessing": true,
        
        serverSide : true,
        processing : true,
        ajax       : {
                        url  : "{{ route('metakey.getmetakey') }}",
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
              {"data" :"place" ,      'name' :'place'},
              {"data" :"hostel" ,    'name' :'hostel'},
              {"data" :"metakey" ,    'name' :'metakey'},
              {"data" :"description", 'name' :'description'},
              {"data" :"search_result_description", 'name' :'search_result_description'},
              {"data" :"action" ,     'name' :'action'},
          
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
    $('.add_metakey').on('click',function(e){
        e.preventDefault();
        save_method = "add";
        /* cities  */
        $('#city').empty();
        $('#city').prepend('<option disabled selected="selected">Please select city</option>');
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
        /* places */
        $('#place').empty();
        $('#place').prepend('<option disabled selected="selected">Please select place</option>');
        $.get("{{URL::to('/easy-hostel/place/getallplace')}}", function(data){
            // console.log(data.result);
            if(data.status == "success"){
                $.each(data.result, function( key, value ) {
                    $('#place').append($('<option>', { 
                            value: value.id,
                            text : value.title,
                    })); 
                });
            }
        });
        /* hostel */
        $('#hostel').empty();
        $('#hostel').prepend('<option disabled selected="selected">Please select hostel</option>');
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
        $('.modal-title').text('Meta Key Description Add Form. Among City, Place & Hostel please select only one!');
        $('.saveMetaKey').text('Save changes');
        $('#metakey_modal').modal('show');
    });
    /* form validaion */
    var validator = $("#metakeyForm").validate({
        ignore: "",
        rules: {
            meta_key: {
                required: true,
            },
            description: {
                required: true,
            }
        },

        errorPlacement: function(label, element) {

            // position error label after generated textarea

            if (element.is("textarea")) {

                label.insertAfter(element.next());

            } else {

                label.insertAfter(element)

            }

        }
    });
    /* when save button click */
    $('.saveMetaKey').click(function(e){
        e.preventDefault();
        tinyMCE.triggerSave();
        if($('#metakeyForm').valid()){
        /* check adding new data or updating existing data  */
        if(save_method == 'add')
        {
            uri = "{{route('metakey.store')}}";
        }
        else{
            var metakey_id  = $(".metakey-id").val();
            uri = "{{ URL::to('/easy-hostel/metakey/update') }}" + "/" + metakey_id;
        }
        /* form data */
        var result = new FormData($("#metakeyForm")[0]);
        $.ajax({
            data: result,
            url: uri,
            type: "POST",
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                
                if(data.status=='success'){
                    $('#metakeyForm').trigger("reset");
                    $('#metakey_modal').modal('hide');
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
                            title: 'Meta Key Description Added Successfully'
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
                            title: 'Meta Key Description Updated successfully'
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
    $("body").on('click','.metakey-edit', function(e){
        e.preventDefault();
       
        save_method = "edit";
        /* cities  */
        $('#city').empty();
        $('#city').prepend('<option disabled selected="selected">Please select city</option>');
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
        /* places */
        $('#place').empty();
        $('#place').prepend('<option disabled selected="selected">Please select place</option>');
        $.get("{{URL::to('/easy-hostel/place/getallplace')}}", function(data){
            // console.log(data.result);
            if(data.status == "success"){
                $.each(data.result, function( key, value ) {
                    $('#place').append($('<option>', { 
                            value: value.id,
                            text : value.title,
                    })); 
                });
            }
        });
        /* hostel */
        $('#hostel').empty();
        $('#hostel').prepend('<option disabled selected="selected">Please select hostel</option>');
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
        metakey_id = $(this).attr('data-metakey-id');
        $.ajax({
            url:"{{ URL::to('easy-hostel/metakey/edit') }}" + "/" + metakey_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                // console.log(data.result.description)
                if(data.status == "success"){
                    $('.modal-title').text("Update Meta Key Description. Among City, Place & Hostel please select only one!");
                    $('.metakey-id').val(data.result.id);
                     if(data.result.city_id){
                        $('.city').val(data.result.city_id);
                    }
                    if(data.result.place_id){
                        $('.place').val(data.result.place_id);
                    }
                   
                    if(data.result.hostel_id){
                        $('.hostel').val(data.result.hostel_id);
                    }

                    $('.meta_key').val(data.result.meta_key);
                    
                    tinyMCE.get('description').setContent(data.result.description);

                    $('.description').val(data.result.description);
                    
                    if(data.result.search_result_description != null){
                        tinyMCE.get('search_result_description').setContent(data.result.search_result_description);

                        $('.search_result_description').val(data.result.search_result_description);
                    }

                    
                    
                    $('.saveMetaKey').text("Update changes");
                    $('#metakey_modal').modal('show');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
    /* when delete button clicked */
    $("body").on('click','.metakey-delete', function(e){
        e.preventDefault();
        metakey_id  = $(this).attr('data-metakey-id');
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
                    url:"{{URL::to('easy-hostel/metakey/delete')}}" + "/" + metakey_id,
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
                                title: 'Meta Key Description Deleted successfully'
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
        $('#metakeyForm')[0].reset();
        $("#metakeyForm").validate().resetForm();
        $('#city').empty();
        $('#place').empty();
        $('#hostel').empty();
    })
});
</script>
@endsection