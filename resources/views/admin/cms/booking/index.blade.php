@extends('admin.layout.master')

@section('css')

<style>



</style>

@endsection

@section('content')

<div class="card" style="width: 100%">

    <div class="card-header">

        <h4 class="m-0 font-weight-bold text-primary">Booking Table</h4>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <div>

                <table class="stripe" id="tbl_booking">

                    <thead class="thead-light">

                        <tr>

                            <th>S.N.</th>

                            <th>Name</th>

                            <th>Address</th>

                            <th>Phone</th>

                            <th>Email</th>                           

                            <th>Hostel Name</th>

                            <th>Type</th>

                            <th>Length Of Stay</th>

                            <th>Room Type</th>

                            <th>No Of People</th>

                            <th>City</th>

                            <th>Place</th>

                        </tr>

                    </thead>

                    <tbody>

                        

                    </tbody>

                </table>

            </div>

                

        </div>

    </div>

    

</div>

@endsection

@section('js')

<script type="text/javascript">

$(document).ready( function () {

    

    /* datatable */

    var bookgin_table = $('#tbl_booking').DataTable({

        dom: 'Bfrtip',

        LengthChange: true,

        "bProcessing": true,

        

        serverSide : true,

        processing : true,

        ajax       : {

                        url  : "{{ route('bookings.getbooking') }}",

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

             

              {"data" :"name" ,       'name' :'bookings.name'},

              {"data" :"address" ,       'name' :'bookings.address'},

              {"data" :"phone" ,       'name' :'bookings.phone'},

              {"data" :"email" ,       'name' :'bookings.email'},

              {"data" :"hostel_name" ,       'name' :'bookings.hostel_name'},

              {"data" :"type" ,       'name' :'bookings.type'},

              {"data" :"length_of_stay" ,       'name' :'bookings.length_of_stay'},

              {"data" :"room_type" ,       'name' :'bookings.room_type'},

              {"data" :"no_of_people" ,       'name' :'bookings.no_of_people'},

              {"data" :"city" ,       'name' :'bookings.city'},

              {"data" :"place" ,       'name' :'bookings.place'},

          

        ]

    });//end of datatable

    

});

</script>

@endsection