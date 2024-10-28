<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Image;
use App\Model\MobileApp;

class MobileAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mobapp = MobileApp::all();
        return view('admin.cms.mobileapp.index')->with('mobapp',$mobapp);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if($request->hasFile('android_image')) {
            $android_image              = $request->file('android_image');
            $AndroidImageUpload         = Image::make($android_image)->resize(100, 100);
            // dd($AndroidImageUpload);
            $android_name               = time().'.' . $android_image->getClientOriginalExtension();
            $android_destinationPath    = '/uploads/mobileapp/';
            $AndroidImageUpload->save($android_destinationPath.$android_name);  
        }else{
            $android_name = '';
        }
        if($request->hasFile('ios_image')) {
            $ios_image                  = $request->file('ios_image');
            $IosImageUpload             = Image::make($ios_image)->resize(100, 100);
            $ios_name                   = time().rand(0,10). '.' .$ios_image->getClientOriginalExtension();
            $isodestinationPath         = '/uploads/mobileapp/';
            $IosImageUpload->save($isodestinationPath.$ios_name);  
        }else{
            $ios_name = '';
        }

        $social                     = new MobileApp();
        $social->android_image      = $android_name;
        $social->ios_image          = $ios_name;
        $social->android_url        = $request->input('android_url');
        $social->ios_url            = $request->input('ios_url');
        
        if($social->save()){
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
        $app = MobileApp::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$app]);
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
        $app = MobileApp::findOrFail($id);

        if($request->hasFile('android_image')) {
            File::delete('uploads/mobileapp'.'/'.$app->android_image);
            $android_image              = $request->file('android_image');
            $AndroidImageUpload         = Image::make($android_image)->resize(300, 200);
            $android_name               = time().'.' . $android_image->getClientOriginalExtension();
            $destinationPath            = 'uploads/mobileapp/';
            $AndroidImageUpload->save($destinationPath.$android_name);  
        }else{
            $android_name = $app->android_image;
        }
        if($request->hasFile('ios_image')) {
            File::delete('uploads/mobileapp'.'/'.$app->ios_image);
            $ios_image                  = $request->file('ios_image');
            $IosImageUpload             = Image::make($ios_image)->resize(300, 200);
            $ios_name                   = time().rand(0,10). '.' .$ios_image->getClientOriginalExtension();
            $destinationPath            = 'uploads/mobileapp/';
            $IosImageUpload->save($destinationPath.$ios_name);  
        }else{
            $ios_name = $app->ios_image;
        }

        $app->android_image  = $android_name;
        $app->ios_image      = $ios_name;
        $app->android_url    = $request->input('android_url');
        $app->ios_url        = $request->input('ios_url');
        
        if($app->save()){
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
        $app  = MobileApp::findOrFail($id);
        if($app->delete()){
            File::delete('uploads/mobileapp'.'/'.$app->android_image);
            File::delete('uploads/mobileapp'.'/'.$app->ios_image);
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getmobileapp()
    {
        $apps = MobileApp::orderBy('created_at','desc')->select('mobile_apps.*');
        return Datatables($apps)
            ->addColumn('android_image',function($app){
                return asset('/uploads/mobileapp'.'/'.$app->android_image); 
            })
            ->addColumn('ios_image',function($app){
                return asset('/uploads/mobileapp'.'/'.$app->ios_image); 
            })
            
            ->addColumn('android_url',function($app){
                return $app->android_url; 
            })
            ->addColumn('ios_url',function($app){
                return $app->ios_url; 
            })
           
            ->addColumn('action',function($app){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    
                                        <a class="dropdown-item mobileapp-edit"  data-mobileapp-id="'.$app->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item mobileapp-delete"  data-mobileapp-id="'.$app->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
}
