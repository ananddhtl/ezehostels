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

#ads_preview_image {
    margin-top: 5px;
}

#upload_prev {
    position: relative;
    -moz-box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
    -webkit-box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);
    box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);
    padding: 10px;
    margin-bottom: 5px;
    background: white;
}

/* Make the image fit the box */
#upload_prev img {
    width: 100%;
    border: 0px solid #8a4419;
    border-style: inset;
}

.modal-body {}
</style>
@endsection
@section('content')
<div class="card" style="width: 100%">
    <div class="card-header">
        <h4 class="m-0 font-weight-bold text-primary">
            <a href="javascript:void(0)" type="button" class="btn btn-default btn-sm add-place-ads">add new ads</a>
            Place Ads Table
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <table class="stripe" id="tbl_place_ads">
                    <thead class="thead-light">
                        <tr>
                            <th>S.N.</th>
                            <th>Place</th>
                            <th>Image</th>
                            <th>Ads URL</th>
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
    <div class="modal fade" id="site_ads_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title-default">Type your modal title</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" name="siteadsForm" id="siteadsForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="site-ads-id" value="">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Place Name</label>
                                <select name="placeid" class="form-control placeid" required
                                    data-msg="Please select place" id="placeid">

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Site Ads URL</label>
                                <input type="text" name="ads_link" class="form-control ads_link" required
                                    data-msg="Social site ads url shouldn't be empty">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="image">Image</label>
                                <div id="upload_prev">
                                    <img id="ads_preview_image" src="" width="100%" height="200" />
                                </div>
                                <div class="custom-file overflow-hidden rounded-pill">
                                    <input id="customFile" type="file" class="custom-file-input rounded-pill image"
                                        name="image">

                                    <label for="customFile" class="custom-file-label rounded-pill">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm saveSiteAds">Save changes</button>
                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
    /* datatable */
    var site_ads_table = $('#tbl_place_ads').DataTable({
        dom: 'Bfrtip',
        LengthChange: true,
        "bProcessing": true,

        serverSide: true,
        processing: true,
        ajax: {
            url: "{{ route('placeads.getplaceads') }}",
            type: 'GET',
            data: {
                _token: "{{csrf_token()}}"
            }
        },
        columns: [

            {
                "data": "id",
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "data": "placeid",
                'name': 'placeid'
            },
            {
                'render': function(data, type, JsonResultRow, meta) {
                    return "<img src='" + JsonResultRow.image + "' height='100px' width='100'>";
                }
            },
            {
                "data": "ads_link",
                'name': 'ads_link'
            },
            {
                "data": "action",
                'name': 'action'
            },

        ]
    }); //end of datatable
    /* image upload preview */
    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#' + id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#customFile").change(function() {
        readURL(this, 'ads_preview_image');
    });
    /* csrf token setup */
    var uri, save_method;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* when add button click */
    $('.add-place-ads').on('click', function(e) {
        e.preventDefault();
        save_method = "add";
        $('#placeid').empty();
        $('#placeid').prepend(
            '<option disabled="disabled" selected="selected">Please select place</option>');
        $.get("{{URL::to('/easy-hostel/place/getallplace')}}", function(data) {
            // console.log(data.result);
            if (data.status == "success") {
                $.each(data.result, function(key, value) {
                    $('#placeid').append($('<option>', {
                        value: value.id,
                        text: value.title,
                    }));
                });
            }
        });
        $('.modal-title').text('Place Ads Add Form');
        $('.saveSiteAds').text('Save changes');
        $('#site_ads_modal').modal('show');
    });
    /* form validaion */
    var validator = $("#siteadsForm").validate({
        rules: {
            placeid: {
                required: true,
            },
            ads_link: {
                required: true,
            },
            image: {
                required: false,
            }
        }
    });
    /* when save button click */
    $('.saveSiteAds').click(function(e) {
        e.preventDefault();
        tinyMCE.triggerSave();
        if ($('#siteadsForm').valid()) {
            /* check adding new data or updating existing data  */
            if (save_method == 'add') {
                uri = "{{route('placeads.store')}}";
            } else {
                var site_ads_id = $(".site-ads-id").val();
                uri = "{{ URL::to('/easy-hostel/placeads/update') }}" + "/" + site_ads_id;
            }
            /* form data */
            var result = new FormData($("#siteadsForm")[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Add CSRF token from meta tag
                },
                data: result,
                url: uri,
                type: "POST",
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(data) {

                    if (data.status == 'success') {
                        $('#siteadsForm').trigger("reset");
                        $('#site_ads_modal').modal('hide');
                        // based on store or update method showing alert information
                        if (save_method == 'add') {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                type: 'success',
                                title: 'Place Ads Added Successfully'
                            });
                            site_ads_table.ajax.reload();

                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            Toast.fire({
                                type: 'success',
                                title: 'Place ADs Updated successfully'
                            });
                            site_ads_table.ajax.reload();

                        }
                    } else {
                        swal('Not allowed!!', 'error');
                    }
                },
                error: function(data) {
                    swal('Somethings error');
                }
            });
        }
    });
    /* when edit button clicked */
    $("body").on('click', '.site-ads-edit', function(e) {
        e.preventDefault();

        save_method = "edit";
        $('#placeid').empty();
        $('#placeid').prepend(
            '<option disabled="disabled" selected="selected">Please select place</option>');
        $.get("{{URL::to('/easy-hostel/place/getallplace')}}", function(data) {
            // console.log(data.result);
            if (data.status == "success") {
                $.each(data.result, function(key, value) {
                    $('#placeid').append($('<option>', {
                        value: value.id,
                        text: value.title,
                    }));
                });
            }
        });
        site_ads_id = $(this).attr('data-site-ads-id');
        $.ajax({
            url: "{{ URL::to('easy-hostel/placeads/edit') }}" + "/" + site_ads_id,
            type: "GET",
            dataType: 'json',
            success: function(data) {
                // console.log(data.result.description)
                if (data.status == "success") {
                    $('.modal-title').text("Update Service");
                    $('.site-ads-id').val(data.result.id);
                    $('.placeid').val(data.result.placeid);
                    $('.ads_link').val(data.result.ads_link);

                    var image = "{{asset('/uploads/placeads')}}" + "/" + data.result.image;
                    $("#ads_preview_image").attr('src', image);

                    $('.saveSiteAds').text("Update changes");
                    $('#site_ads_modal').modal('show');
                }
            },
            error: function(data) {
                console.log('Error:', data);
            }
        });
    });

    /* when delete button clicked */
    $("body").on('click', '.site-ads-delete', function(e) {
        e.preventDefault();
        site_ads_id = $(this).attr('data-site-ads-id');
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
                    url: "{{URL::to('easy-hostel/placeads/delete')}}" + "/" +
                        site_ads_id,
                    type: "GET",
                    dataType: "Json",
                    data: {
                        _token: "{{csrf_token()}}"
                    },
                    success: function(data) {
                        if (data.status == "success") {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                type: 'success',
                                title: 'Place Ads Deleted successfully'
                            });
                            site_ads_table.ajax.reload();

                        } else {
                            swal('Not allowed!!', 'error');

                        }
                    },
                });
            } else {
                Swal.fire(
                    'Cancelled',
                    'Your content is safe :)',
                    'error'
                )
            }
        })
    });


    /* reset form field when modal closed */
    $('.modal').on('hidden.bs.modal', function() {
        $('#siteadsForm')[0].reset();
        $("#siteadsForm").validate().resetForm();
        $('#ads_preview_image').attr('src', '');
    })
});
</script>
@endsection