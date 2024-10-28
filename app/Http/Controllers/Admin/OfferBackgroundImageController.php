<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OfferBackgroundImage;
use File;
use Image;

class OfferBackgroundImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $background_image = OfferBackgroundImage::all();
        return view('admin.cms.offerbannerimage.index')->with(['image'=>$background_image]);
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
        $background_image = new OfferBackgroundImage();
        $background_image->image = $name;
        
        if($background_image->save()){
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
        $background_image = OfferBackgroundImage::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$background_image]);
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
        $background_image = OfferBackgroundImage::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$background_image]);
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
        $background_image = OfferBackgroundImage::findOrFail($id);
        
        if($request->hasFile('image')) {
            File::delete('uploads'.'/'.$background_image->image);
            $image              = $request->file('image');
            $ImageUpload        = Image::make($image)->resize(1000, 1000);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = $background_image->image;
        }
        $background_image->image = $name;
        
        if($background_image->save()){
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
        $background_image  = OfferBackgroundImage::findOrFail($id);
        if($background_image->delete()){
            File::delete('uploads'.'/'.$background_image->image);
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getofferbackgroundimage ()
    {
        $background_images = OfferBackgroundImage::orderBy('created_at','desc')->select('offer_background_images.*');
        return Datatables($background_images)
            ->addColumn('image',function($background_image){
                return asset('/uploads'.'/'.$background_image->image); 
            })
            ->addColumn('action',function($background_image){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item offer-background-image-detail"  data-offer-background-image-id="'.$background_image->id.'" style="cursor:pointer">View Detail</a>
                                        <a class="dropdown-item offer-background-image-edit"  data-offer-background-image-id="'.$background_image->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item offer-background-image-delete"  data-offer-background-image-id="'.$background_image->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
}
