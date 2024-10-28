<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Booking;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cms.booking.index');
    }

    public function getbooking()
    {
        $bookings = Booking::orderBy('created_at','desc')->select('bookings.*');
        return Datatables($bookings)
            ->addColumn('name',function($blog){
                return $blog->name; 
            })
            ->addColumn('email',function($blog){
                return $blog->email; 
            })
            ->addColumn('address',function($blog){
                return $blog->address; 
            })
            ->addColumn('phone',function($blog){
                return $blog->phone; 
            })
            ->addColumn('hostel_name',function($blog){
                return $blog->hostel_name; 
            })
            ->addColumn('city',function($blog){
                return $blog->city; 
            })
            ->addColumn('place',function($blog){
                return $blog->place; 
            })
            ->addColumn('type',function($blog){
                return $blog->type; 
            })
            ->addColumn('length_of_stay',function($blog){
                return $blog->length_of_stay; 
            })
            ->addColumn('room_type',function($blog){
                return $blog->room_type; 
            })
            ->addColumn('no_of_people',function($blog){
                return $blog->no_of_people; 
            })
            ->make(true);
    }
}
