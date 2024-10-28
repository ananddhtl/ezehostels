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

                        <th>Image</th>

                        <th>Action</th>

                    </thead>

                    <tbody>

                    @php

                        $i=1;

                    @endphp

                    @foreach($hostels as $hostel)

                    @foreach($hostel->hostelgallery as $gallery)

                    <tr>

                        <td>{{ $i }}</td>

                        <td>{{ $gallery->hostel->title }}</td>

                        <td><img src="{{ asset('uploads/hostelgallery'.'/'.$gallery->image) }}" alt="img" height="80" width="100"></td>

                        <td>

                            <a href="{{ route('vendorhostelgalleryedit',$gallery->id) }}"><i class="fa fa-edit"></i></a>

                            <a onclick="return confirm('Are you sure you want to delete this item?');" href="{{ route('vendorhostelgallerydelete',$gallery->id) }}"><i class="fa fa-trash"></i></a>

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