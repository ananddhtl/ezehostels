<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\HostelGallery;
use File;
use Image;

class HostelGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.cms.hostelgallery.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        if ($image = $request->file('image')) {
            // dd($image);
            foreach ($image as  $value) {
                $destinationPath   = 'uploads/hostelgallery/';
                $name              = time(). rand(0,100) . '.' . $value->getClientOriginalExtension();
                $ImageUpload       = Image::make($value)->resize(1000, 1000);

                $ImageUpload->save($destinationPath.$name);  

                $hostel_gallery             = new HostelGallery();
                $hostel_gallery->hostel_id  = $request->hostel;
                $hostel_gallery->image      = $name;
                $hostel_gallery->save();
            }
        }
        return response()->json(['status'=>'success']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $logo = HostelGallery::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$logo]);
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
        $logo = HostelGallery::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$logo]);
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
        $hostel_gallery = HostelGallery::findOrFail($id);
        // dd($request->file('image')[0]);
        // dd($hostel_gallery->image);
        if($request->hasFile('image')) {
            File::delete('uploads/hostelgallery'.'/'.$hostel_gallery->image);
            $image              = $request->file('image');
            // $ImageUpload        = Image::make($image[0])->resize(1000, 1000);
            $name               = time().'.' . $image[0]->getClientOriginalExtension();
            $destinationPath    = 'uploads/hostelgallery';
            $image[0]->move($destinationPath,$name);  
        }else{
            $name = $hostel_gallery->image;
        }
        $hostel_gallery->image = $name;
        
        if($hostel_gallery->save()){
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
        $hostel_gallery  = HostelGallery::findOrFail($id);
        if($hostel_gallery->delete()){
            File::delete('uploads/hostelgallery'.'/'.$hostel_gallery->image);
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function gethostelgallery()
    {
        $hostel_galleries = HostelGallery::latest()->get();
        return Datatables($hostel_galleries)
            ->addColumn('hostel',function($hostel_gallerie){
                return $hostel_gallerie->hostel->title; 
            })
            ->addColumn('image',function($hostel_gallerie){
                return asset('/uploads/hostelgallery'.'/'.$hostel_gallerie->image); 
            })
            ->addColumn('action',function($hostel_gallerie){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item hostel-gallery-detail"  data-hostel-gallery-id="'.$hostel_gallerie->id.'"style="cursor:pointer">View Detail</a>
                                        <a class="dropdown-item hostel-gallery-edit"  data-hostel-gallery-id="'.$hostel_gallerie->id.'"style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item hostel-gallery-delete"  data-hostel-gallery-id="'.$hostel_gallerie->id.'"style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
}
