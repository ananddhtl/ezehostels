<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\HomeBackgroundImage;
use App\Model\Hostel;
use App\Model\OfferBackgroundImage;
use App\Model\Service;
use App\Model\City;
use App\Model\Place;
use App\Model\SiteAds;
use App\Model\MetaKey;


class HomeController extends Controller
{
    protected $total_records  = 0;
    protected $per_page       = 15;
    protected $offset         = 0;
    protected $current_page   = 1;

    public function index()
    {
        $f    = Hostel::where('publish','yes')->where('featured','yes')->select('*')->orderBy('hostel_order','asc')->take(18)->get();
        if($f->count() > 0){
            $featured_hostel = $f;
        }else{
            $featured_hostel = '';
        }



        $l      = Hostel::where('publish','yes')->where('featured','no')->select('*')->orderBy('created_at','desc')->take(3)->get();
        if($l->count() > 0){
            $latest_hostel = $l;
        }else{
            $latest_hostel = '';
        }
        
       

        $s            = Service::where('show_on_front','yes')->select('image','title')->take(4)->get();
        if($s->count() > 0){
            $service = $s;
        }else{
            $service = '';
        }
        
        $a                = SiteAds::select('image','ads_link')->orderBy('site_order','asc')->get();
        if($a->count() > 0){
            $ads = $a;
        }else{
            $ads = '';
        }


        $ob       = OfferBackgroundImage::select('image')->get();
        if($ob->count() > 0){
            $offer_banner = $ob;
        }else{
            $offer_banner = '';
        }


        $hb    = HomeBackgroundImage::select('image')->get(); 
        if($hb->count() > 0){
            $home_background = $hb;
        }else{
            $home_background = '';
        }
 
        $c             = City::select('id','title','slug')->get();
        if($c->count() > 0){
            $cities = $c;
        }else{
            $cities = '';
        }

        $bg  = Blog::select('id','slug','title','date','image','description')->orderBy('created_at','desc')->take(3)->get();
        if($bg->count() > 0){
            $blog = $bg;
        }else{
            $blog = '';
        }
        
        return view('front.index')->with([
            'featured_hostels'  =>  $featured_hostel,
            'latest_hostels'    =>  $latest_hostel,
            'services'          =>  $service,
            'offer_banner'      =>  $offer_banner,
            'home_background'   =>  $home_background,
            'ads'               =>  $ads,
            'cities'            =>  $cities,
            'blogs'             =>  $blog,
            
            
        ]);
    }

    /**
    * function to search the hostel by the the filer paramaters
    * @param \Illuminate\Http\Request
    * @return void
    **/
    public function search(Request $request)
    {		
        
        $this->current_page = $request->has('current_page') ? $request->get('current_page') :  $this->current_page;
        $this->offset       = ($this->current_page - 1) * $this->per_page;
        //search by filter parameters
        $hostels = Hostel::where(function($query)use($request){
            //check the request has city or not
            if($request->has('city') && $request->input('city') != "" && $request->input('city') != "all-over-nepal"):
                $query->where('city',$request->input('city'));
            endif;
            //check the request has place or not
            if($request->has('place') && $request->input('place') != ""):
                $query->where('place',$request->input('place'));
            endif;
            //
            if($request->has('type') && $request->input('type') != ""):
                $query->where('type',$request->input('type'));
            endif;
            //check for the hostel title
            if($request->has('hostel_name') && $request->input('hostel_name') != ""):
                $query->where('title','LIKE','%'.$request->input('hostel_name').'%');
            endif;

            // check for the min max value
            if($request->has('min_price') && $request->has('max_price')):
                $query->whereBetween('price',[$request->input('min_price'),$request->input('max_price')]);
            endif;

            // check for services
            if($request->has('services')):
                $s = '';
                foreach($request->input('services') as $service){
                    $s = $service;
                }
                $query->whereHas('hostelservices', function($q) use ($s){
                        $q->where('service','LIKE','%'.$s.'%');
                });
            endif;


        })->whereHas('hostelprices', function($q) use ($request){
            //if the request has the room type onlye
            if($request->has('room_type') && $request->input('room_type') != ""):
                return $q->where('room_type',$request->input('room_type'));
            endif;
        })->where('publish','yes');



        // check request has sort or not
        if($request->has('sort') && $request->input('sort') != ""):
            if($request->input('sort') == 'low_to_high'):
                $hostels = $hostels->orderBy('price','asc');
            else:
                $hostels = $hostels->orderBy('price','desc');
            endif;
        endif;

        

        /*getting metakey description based on city place */
        $meta_description     = '';
        $meta_key             = '';
        $description          = '';
        if($request->has('city') && $request->input('city') != "" && $request->input('city') != "all-over-nepal"):
            $c                = City::where('title',$request->input('city'))->first();
            $meta_description = MetaKey::where('city_id',$c->id)->select('search_result_description')->first();
            $description      = MetaKey::where('city_id',$c->id)->select('description')->first();
            $meta_key         = MetaKey::where('city_id',$c->id)->select('meta_key')->first();
        endif;
        if($request->has('place') && $request->input('place') != ""):
            $p                = Place::where('title',$request->input('place'))->first();
            $meta_description = MetaKey::where('place_id',$p->id)->select('search_result_description')->first();
            $description      = MetaKey::where('place_id',$p->id)->select('description')->first();
            $meta_key         = MetaKey::where('place_id',$p->id)->select('meta_key')->first();
        endif;
        

        $this->total_records    = $hostels->count();
        $hostels                = $hostels->take($this->per_page)->skip($this->offset)->get();
        $service                = Service::select('id','title')->get();
        $city                   = City::select('id','title')->get();


        
       

        if ($request->ajax()) {
            $return_html =  view('front.pagination')->with([
                'hostels'           => $hostels,
                'total_records'     => $this->total_records,
                'per_page'          => $this->per_page,
                'pagination'        => $this->ezePagination(),
            ])->render();
            //now return response back to the client
            return response()->json(array('status' => 'success','description'=>$description, 'meta_description'  =>  $meta_description,'meta_key' =>  $meta_key, 'message' => $return_html,'total_record' => $this->total_records),200);
        }
        return view('front.hostel-list')->with([
            'hostels'           =>  $hostels,
            'services'          =>  $service,
            'cities'            =>  $city,
            'total_records'     =>  $this->total_records,
            'per_page'          =>  $this->per_page,
            'pagination'        =>  $this->ezePagination(),
            'meta_description'  =>  $meta_description,
            'meta_key'          =>  $meta_key,
            'description'       =>  $description
           
        ]);

    }

   


    public function ezePagination()
    {
        $total_pages           = round($this->total_records / $this->per_page);
        $_return_pagination    = "";
        //check the total_record is greater and the total possible pages is greater than 0 only
        if($this->total_records > $this->per_page && $total_pages > 1):
            $_return_pagination .= '
            <div class="paginations">
                <nav>
                    <ul class="pagination" role="navigation">
                        <li class="page-item';
                        if($this->current_page <= 1):
                            $_return_pagination .= ' disabled';
                        endif;
                        $_return_pagination .= '"><a href="#'.($this->current_page - 1).'" class="page-link">Previous</a></li>';
                        $after_dots = false;
                        $before_dots = false;
                        for($i = 1;$i <= $total_pages; $i++):
                            if($i == 1 || $i == 2 || $i == $this->current_page): //show the pagination 1 and 2 for all pages
                                $_return_pagination .= '<li class="page-item';
                                    if($this->current_page == $i):
                                        $_return_pagination .= ' active';
                                    endif;
                                        $_return_pagination .= '"><a class="page-link"  href="#'.$i.'">'.$i.'</a></li>';
                            elseif($i >= 3 && ($i < $total_pages) && ($i < ($total_pages -1) )): //check for the pagination page is greate than 2 and less than total pages and total pages -1
                                 if($i == ($this->current_page + 1) || $i == ($this->current_page + 2)): //need to show the mid value 2
                                    $_return_pagination .= '<li class="page-item';
                                        if($this->current_page == $i):
                                            $_return_pagination .= ' active';
                                        endif;
                                        $_return_pagination .= '"><a class="page-link"  href="#'.$i.'">'.$i.'</a></li>';
                                 elseif($i == ($this->current_page - 1) || $i == ($this->current_page - 2)):
                                    $_return_pagination .= '<li class="page-item';
                                        if($this->current_page == $i):
                                            $_return_pagination .= ' active';
                                        endif;
                                        $_return_pagination .= '"><a class="page-link"  href="#'.$i.'">'.$i.'</a></li>';
                                 elseif($i > ($this->current_page + 2)):
                                        if(!$after_dots):
                                            $_return_pagination .= '<li class="page-item disabled"><a class="page-link" href="#">..</a></li>';
                                            $after_dots = true;
                                        endif;
                                 elseif($i < ($this->current_page - 2) ):
                                        if(!$before_dots):
                                            $_return_pagination .= '<li class="page-item disabled"><a class="page-link" href="#">..</a></li>';
                                            $before_dots = true;
                                        endif;
                                 else:
                                     $_return_pagination .= '<li class="page-item';
                                       if($this->current_page == $i):
                                            $_return_pagination .= ' active';
                                       endif;
                                       $_return_pagination .='"><a class="page-link"  href="#'.$i.'">'.$i.'</a></li>';
                                 endif;
                            else:
                                  $_return_pagination .= '<li class="page-item';
                                   if($this->current_page == $i):
                                        $_return_pagination .= ' active';
                                   endif;
                                   $_return_pagination .='"><a class="page-link"  href="#'.$i.'">'.$i.'</a></li>';
                            endif; // end of the number of page count
                        endfor;
                        $_return_pagination .= '<li class="page-item';
                            if($this->current_page == $total_pages):
                                 $_return_pagination  .= ' disabled';
                            endif;
                            $_return_pagination .= '"><a class="page-link" href="#'.($this->current_page + 1).'">Next</a></li>';
                        $_return_pagination .= '      
                    </ul>
                </nav>
            </div>';
        endif;
        //return the pagination html
        return $_return_pagination;
    }

    
}
