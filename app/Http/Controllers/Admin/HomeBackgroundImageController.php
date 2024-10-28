<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\HomeBackgroundImage;
use Image;
use File;

class HomeBackgroundImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $home_image = HomeBackgroundImage::all();
        return view('admin.cms.homebannerimage.index')->with(['image'=>$home_image]);
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
            $ImageUpload        = Image::make($image)->resize(1000, 1000);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/';
            $ImageUpload->save($destinationPath.$name);  
        }
        $home_image = new HomeBackgroundImage();
        $home_image->image = $name;
        
        if($home_image->save()){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $home_image = HomeBackgroundImage::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$home_image]);
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
        $home_image = HomeBackgroundImage::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$home_image]);
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
        $home_image = HomeBackgroundImage::findOrFail($id);
        
        if($request->hasFile('image')) {
            File::delete('uploads'.'/'.$home_image->image);
            $image              = $request->file('image');
            $ImageUpload        = Image::make($image)->resize(1000, 1000);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = $home_image->image;
        }
        $home_image->image = $name;
        
        if($home_image->save()){
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
        $home_image  = HomeBackgroundImage::findOrFail($id);
        if($home_image->delete()){
            File::delete('uploads'.'/'.$home_image->image);
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function gethomebackgroundimage ()
    {
        $home_images = HomeBackgroundImage::latest()->get();
        return Datatables($home_images)
            ->addColumn('image',function($home_image){
                return asset('/uploads'.'/'.$home_image->image); 
            })
            ->addColumn('action',function($home_image){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item home-background-image-detail"  data-home-background-image-id="'.$home_image->id.'" style="cursor:pointer">View Detail</a>
                                        <a class="dropdown-item home-background-image-edit"  data-home-background-image-id="'.$home_image->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item home-background-image-delete"  data-home-background-image-id="'.$home_image->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
}

