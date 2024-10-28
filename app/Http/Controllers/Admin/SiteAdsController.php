<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SiteAds;
use File;
use Image;
use DataTables;

class SiteAdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cms.siteads.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('image')) {
            $image              = $request->file('image');
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/siteads/';
            $image->move($destinationPath,$name);   
        }else{
            $name = '';
        }
        $site_ads             = new SiteAds();
        $site_ads->image      = $name;
        $site_ads->ads_link   = $request->input('ads_link');
        $site_ads->site_order  = $request->input('site_order');
       
        
        if($site_ads->save()){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    
    }

    

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $site_ads = SiteAds::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$site_ads]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $site_ads = SiteAds::findOrFail($id);

        if($request->hasFile('image')) {
            File::delete('uploads/siteads'.'/'.$site_ads->image);
            $image              = $request->file('image');
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/siteads/';
            $image->move($destinationPath,$name);  
        }else{
            $name = $site_ads->image;
        }
       
        $site_ads->image    = $name;
        $site_ads->ads_link = $request->input('ads_link');
         $site_ads->site_order  = $request->input('site_order');
       
        
        if($site_ads->save()){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $site_ads  = SiteAds::findOrFail($id);
        if($site_ads->delete()){
            File::delete('uploads/siteads'.'/'.$site_ads->image);
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getads()
    {
        $site_ads = SiteAds::orderBy('created_at','desc')->select('site_ads.*');
        return Datatables($site_ads)
            ->addColumn('image',function($site_ad){
                return asset('/uploads/siteads'.'/'.$site_ad->image); 
            })
            ->addColumn('ads_link',function($site_ad){
                return $site_ad->ads_link; 
            })
             ->addColumn('site_order',function($site_ad){
                return $site_ad->site_order; 
            })
           
            ->addColumn('action',function($site_ad){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    
                                        <a class="dropdown-item site-ads-edit"  data-site-ads-id="'.$site_ad->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item site-ads-delete"  data-site-ads-id="'.$site_ad->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
}
