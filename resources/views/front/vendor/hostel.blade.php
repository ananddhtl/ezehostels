@extends('front.layouts.master')
@section('title')
User Dashboard
@endsection
@section('content')

<div class="main-content">
   <div class="container-fluid">

    <div class="row">

        <div class="col-md-12">

            <div class="table-responsive">

                <table id="mytable" class="table table-bordred table-striped">

                    <thead>

                        <th>S.N.</th>

                        <th>Image</th>

                        <th>Name</th>

                        <th>Address</th>

                        <th>Type</th>

                        <th>Services</th>

                        <th>Description</th>

                        <th>Policies</th>

                        <th>Price</th>

                        <th>Action</th>

                    </thead>

                    <tbody>

                    @php

                        $i=1;

                    @endphp

                    @foreach($hostels as $hostel)

                    <tr>

                        <td>{{ $i }}</td>

                        <td><img src="{{ asset('uploads/hostels'.'/'.$hostel->image) }}" alt="img" height="80" width="100"></td>

                        <td>{{ $hostel->title }}</td>

                        <td>{{ $hostel->place}}, {{ $hostel->city }}</td>

                        <td>{{ $hostel->type }}</td>

                        <td>{{ $hostel->service }}</td>

                        <td>{!! $hostel->description !!}</td>

                        <td>{!! $hostel->policies !!}</td>

                        <td>{{ $hostel->price }}</td>

                        <td>

                            <a href="{{ route('vendorhosteledit',$hostel->id) }}"><i class="fa fa-edit"></i></a>

                            <a onclick="return confirm('Are you sure you want to delete this hostel?');" href="{{ route('vendorhosteldelete',$hostel->id) }}"><i class="fa fa-trash"></i></a>

                        </td>

                    </tr>

                    @php

                        $i++;

                    @endphp

                    @endforeach

                    </tbody>

                </table>

            </div>     

        </div>

    </div>

</div> 
</div>

@endsection