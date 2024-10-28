<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\Booking;
use App\Model\HomeBackgroundImage;
use App\Model\Hostel;
use App\Model\OfferBackgroundImage;
use App\Model\Service;
use App\Model\City;
use App\Model\Page;
use App\Model\SiteAds;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
    public function singleHostel(Request $request,$slug)
    {
        // dd($slug);
        $page_title     =   $slug;
        $hostel         =   Hostel::where('publish','yes')->select('*')->where('slug',$slug)->first();

        $near_hostel    =   Hostel::where('publish','yes')->select('*')->where('id', '!=', $hostel->id)->where('place', 'like', '%' . $hostel->place . '%')->inRandomOrder()->limit(4)->get();
        // dd(json_decode($hostel->service));
        $hostel_service = [];
        foreach($hostel->hostelservices as $service){
            $services   = Service::where('title',$service->service)->select('title','image')->orderBy('created_at','desc')->take(4)->get();
            array_push($hostel_service,$services);
        }

        /*checking available room for 0*/
        if($hostel->hostelprices->count() > 0):
            /*checking is hostel room type empty or not*/
            foreach($hostel->hostelprices as $hostelprice):
                if($hostelprice->available_room === 0):
                    $bookout = true;
                else:
                    $bookout = false;
                endif;
            endforeach;
        else:
            $bookout = true;
        endif;
        

        return view('front.single-hostel')->with([
            'hostel'        => $hostel,
            'services'      =>  $hostel_service,
            'near_hostels'  =>  $near_hostel,
            'page_title'    =>  $page_title,
            'bookout'       =>  $bookout
        ]);
    }
    public function getServices()
    {
        $service = Service::select('image','title')->get();
        return view('front.services')->with('services',$service);
    }

    


    /* blog */

    public function getblogs()
    {
        $blogs = Blog::select('id','description','slug','image','date','title')->latest()->paginate(6);
        return view('front.blogs')->with('blogs',$blogs);
    }


    /* single blog */
    public function getsingleblog($slug)
    {
        $blog   = Blog::where('slug',$slug)->first();
        $blogs  = Blog::where('id','!=',$blog->id)->select('id','slug','image','date','title')->take(6)->orderBy('created_at','desc')->get();
        return view('front.single-blog')->with([
            'blog'  =>  $blog,
            'blogs' =>  $blogs
        ]);
    }


    /* getting page info */
    public function getaboutus()
    {
        $aboutus = Page::select('*')->where('slug','about-us')->first();
        return view('front.about-us')->with('aboutus',$aboutus);
    }
    public function getprivacypolicy()
    {
        $privacypolicy = Page::select('*')->where('slug','privacy-policy')->first();
        return view('front.privacy-policy')->with('privacypolicy',$privacypolicy);
    }
    public function gettermconditions()
    {
        $termconditions = Page::select('*')->where('slug','terms-conditions')->first();
        return view('front.term-conditions')->with('termconditions',$termconditions);
    }
    public function getguestpolicy()
    {
        $guestpolicy = Page::select('*')->where('slug','guest-policy')->first();
        return view('front.guest-policy')->with('guestpolicy',$guestpolicy);    
    }





    /* hostel booking */
    public function getbooking(Request $request)
    {
        request()->validate([
            'length_of_stay'  => 'required',
            'room_type'       => 'required',
            'no_of_people'    => 'required',
        ],
        [
            'length_of_stay.required' => 'Please select the length of stay!',
            'room_type.required'      => 'Please select the room type!',
            'no_of_people.required'   => 'Please select the number of people!',
        ]);
        // dd($request->all());
        $data = $request->all();
        return view('front.booking')->with('data',$data);
    }


    /* hostel booked */
    public function book(Request $request)
    {
        $book               = new Booking();
        $book->hostel_name  = $request->hostel_name;
        $book->place        = $request->place;

        $book->length_of_stay   = $request->length_of_stay;
        $book->room_type        = $request->room_type;
        $book->no_of_people     = $request->no_of_people;

        $book->city         = $request->city;
        $book->type         = $request->type;
        $book->name         = $request->name;
        $book->email        = $request->email;
        $book->phone        = $request->phone;
        $book->address      = $request->address;

        $hostel_name        = $request->hostel_name;
        $place              = $request->place;
        $length_of_stay     = $request->length_of_stay;
        $room_type          = $request->room_type;
        $no_of_people       = $request->no_of_people;
        $city               = $request->city;
        $type               = $request->type;
        $name               = $request->name;
        $email              = $request->email;
        $phone              = $request->phone;
        $address            = $request->address;

        $logo = "https://ezehostels.com/uploads/logo.png";

        if($book->save()){
            /* mail for admin */
            Mail::send('mail.booking-to-admin', ['name'=>$name,'email'=>$email,'address'=>$address,'phone'=>$phone,'hostel_name'=>$hostel_name,'city'=>$city,'place'=>$place,'type'=>$type,'length_of_stay'=>$length_of_stay, 'room_type'=>$room_type, 'no_of_people'=>$no_of_people,'logo'=>$logo], function($message) use ($name)
            {       
                $message->to('ezehostels@gmail.com')->subject('Booking for '.$name); 
                
            });

            /* mail for user */
            Mail::send('mail.booking-to-user', ['name'=>$name,'email'=>$email,'address'=>$address,'phone'=>$phone,'hostel_name'=>$hostel_name,'city'=>$city,'place'=>$place,'type'=>$type,'length_of_stay'=>$length_of_stay, 'room_type'=>$room_type, 'no_of_people'=>$no_of_people,'logo'=>$logo], function($message) use ($email)
            {        
                $message->to($email)->subject('Booking Success');
            });

            return response()->json(['status'=>'success']);
        }
    }






    /* all hostels by city */
    public function gethostelbycity(Request $request, $slug)
    {
        $hostels = Hostel::select('*')->where(function($query) use($slug) {
            $query->where('city',$slug);
        })->where('publish','yes')->orderBy("price","asc")->paginate(15);

        /*counting total hostels*/
        $count = Hostel::select('*')->where(function($query) use($slug) {
            $query->where('city',$slug);
        })->where('publish','yes')->orderBy("price","asc")->count();

        $service = Service::select('id','title')->get();
        $city    = City::select('id','title')->get();

        if ($request->ajax()) {
            return view('front.pagination', compact('hostels'));
        }
        return view('front.ajaxPagination')->with([
            'hostels'   =>  $hostels,
            'services'  =>  $service,
            'cities'    =>  $city,
            'count'     =>  $count
        ]);
    }

    /* all hostels by palce */
    public function gethostelbyplace(Request $request,$slug)
    {
        
        $hostels = Hostel::select('*')->where(function($query) use($slug) {
            $query->where('place',$slug);
        })->where('publish','yes')->orderBy("price","asc");
        $count = $hostels->count();
        $hostels = $hostels->paginate(2);
        $service = Service::select('id','title')->get();
        $city    = City::select('id','title')->get();

        if ($request->ajax()) {
            return view('front.pagination', compact('hostels'));
        }
        return view('front.ajaxPagination')->with([
            'hostels'   =>  $hostels,
            'services'  =>  $service,
            'cities'    =>  $city,
            'count'     =>  $count
        ]);
    }

   


    
}
