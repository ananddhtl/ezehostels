@extends('front.layouts.master')
@section('title')
User Dashboard
@endsection
@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">

            <div class="table-responsive">

                <table id="mytable" class="table table-bordred table-striped">

                    <thead>

                        <th>S.N.</th>

                        <th>Hostel Name</th>

                        <th>Room Type</th>

                        <th>Available Room</th>

                        <th>Pricing</th>

                        <th>Action</th>

                    </thead>

                    <tbody>

                    @php

                        $i=1;

                    @endphp

                    @foreach($hostels as $hostel)

                    @foreach($hostel->hostelprices as $price)

                    <tr>

                        <td>{{ $i }}</td>

                        <td>{{ $price->hostel->title }}</td>

                        <td>{{ $price->room_type }}</td>

                        <td>{{ $price->available_room }}</td>

                        <td>{{ $price->pricing }}</td>

                        <td>

                            <a href="{{ route('vendorhostelpricingedit',$price->id) }}"><i class="fa fa-edit"></i></a>

                            <a onclick="return confirm('Are you sure you want to delete this item?');" href="{{ route('vendorhostelpricingdelete',$price->id) }}"><i class="fa fa-trash"></i></a>

                        </td>

                    </tr>

                    @php

                        $i++;

                    @endphp

                    @endforeach

                    @endforeach

                    </tbody>

                </table>

            </div>     

        </div>

    </div>

</div>

@endsection