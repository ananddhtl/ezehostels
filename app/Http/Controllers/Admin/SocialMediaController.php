<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Image;
use App\Model\SocialMedia;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cms.social.index');
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
            $ImageUpload        = Image::make($image)->resize(100, 100);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/socials/';
            $ImageUpload->save($destinationPath.$name);  
        }
        $social        = new SocialMedia();
        $social->image = $name;
        $social->title = $request->input('title');
        $social->url   = $request->input('url');
       
        
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
        $social = SocialMedia::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$social]);
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
        $social = SocialMedia::findOrFail($id);

        if($request->hasFile('image')) {
            File::delete('uploads/socials'.'/'.$social->image);
            $image              = $request->file('image');
            $ImageUpload        = Image::make($image)->resize(100, 100);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/socials/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = $social->image;
        }
       
        $social->image = $name;
        $social->title = $request->input('title');
        $social->url   = $request->input('url');
       
        
        if($social->save()){
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
        $social  = SocialMedia::findOrFail($id);
        if($social->delete()){
            File::delete('uploads/socials'.'/'.$social->image);
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getsocial()
    {
        $socials = SocialMedia::orderBy('created_at','desc')->select('social_media.*');
        return Datatables($socials)
            ->addColumn('image',function($social){
                return asset('/uploads/socials'.'/'.$social->image); 
            })
            ->addColumn('title',function($social){
                return $social->title; 
            })
            ->addColumn('url',function($social){
                return $social->url; 
            })
           
            ->addColumn('action',function($social){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    
                                        <a class="dropdown-item social-edit"  data-social-id="'.$social->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item social-delete"  data-social-id="'.$social->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
}
