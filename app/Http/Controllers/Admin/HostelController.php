<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Hostel;
use App\Model\HostelService;
use Image;
use File;

class HostelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cms.hostel.index');
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
            $destinationPath    = 'uploads/hostels/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = '';
        }
        $hostel                = new Hostel();
        $hostel->image         = $name;
        $hostel->title         = $request->input('title');
        $hostel->price         = $request->input('price');
        $hostel->slug          = str_slug($request->input('title'));
        $hostel->description   = $request->input('description');
        $hostel->type          = $request->input('type');
       
        $hostel->city          = $request->input('city');
        $hostel->place         = $request->input('place');
        $hostel->policies      = $request->input('policies');
        
        $hostel->featured      = $request->input('featured');
        $hostel->hostel_order      = $request->input('hostel_order');
        $hostel->iframe        = $request->input('iframe');
         $hostel->publish      = $request->input('publish');
       
        // dd($hostel);
        if($hostel->save()){
            foreach ($request->service as $s) {
                $hostel->hostelservices()->save(new HostelService(["service" => $s]));
            }
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
        $hostel = Hostel::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$hostel]);
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
        $hostel = Hostel::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$hostel]);
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
        $hostel = Hostel::findOrFail($id);

        if($request->hasFile('image')) {
            File::delete('uploads/hostels'.'/'.$hostel->image);
            $image              = $request->file('image');
            $ImageUpload        = Image::make($image)->resize(1000, 1000);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/hostels/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = $hostel->image;
        }
        $hostel->image         = $name;
        $hostel->title         = $request->input('title');
        $hostel->slug          = str_slug($request->input('title'));
        $hostel->price         = $request->input('price');
        $hostel->description   = $request->input('description');
        $hostel->type          = $request->input('type');
        

        $hostel->city          = $request->input('city');
		if($request->has('place')){
			$hostel->place         = $request->input('place');
		}
        $hostel->place         = $hostel->place;
        $hostel->policies      = $request->input('policies');
        $hostel->iframe        = $request->input('iframe');
         $hostel->publish      = $request->input('publish');
        
        $hostel->featured      = $request->input('featured');
        $hostel->hostel_order      = $request->input('hostel_order');

        if($request->has('service')){
            $hostel->hostelservices()->delete();
            foreach ($request->service as $s) {
                $hostel->hostelservices()->save(new HostelService(["service" => $s]));
            }
        }
       
        // dd($hostel);
        if($hostel->save()){
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
        $hostel  = Hostel::findOrFail($id);
        if($hostel->delete()){
            File::delete('uploads/hostels'.'/'.$hostel->image);
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function gethostel()
    {
        $hostels = Hostel::latest()->get();
        return Datatables($hostels)
            ->addColumn('image',function($hostel){
                return asset('/uploads/hostels'.'/'.$hostel->image); 
            })
            ->addColumn('title',function($hostel){
                return $hostel->title; 
            })
            ->addColumn('price',function($hostel){
                return $hostel->price; 
            })
           
            ->addColumn('price',function($hostel){
                return $hostel->price; 
            })
           
            ->addColumn('city',function($hostel){
                return $hostel->city; 
            })
            ->addColumn('place',function($hostel){
                return $hostel->place; 
            })
            ->addColumn('type',function($hostel){
                return $hostel->type; 
            })
            ->addColumn('publish',function($hostel){
                return $hostel->publish; 
            })
            ->addColumn('featured',function($hostel){
                return $hostel->featured; 
            })
            ->addColumn('hostel_order',function($hostel){
                return $hostel->hostel_order; 
            })
           
           
            ->addColumn('action',function($hostel){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    
                                        
                                        <a class="dropdown-item hostel-edit"  data-hostel-id="'.$hostel->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item hostel-delete"  data-hostel-id="'.$hostel->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
    public function getallhostel()
    {
        $hostel = Hostel::select('id','title')->get();
        return response()->json(['status'=>'success','result'=>$hostel]);
    }
}
