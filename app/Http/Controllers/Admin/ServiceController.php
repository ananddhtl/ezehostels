<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Service;
use Image;
use File;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cms.service.index');
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
            $destinationPath    = 'uploads/services/';
            $ImageUpload->save($destinationPath.$name);  
        }
        $service                = new Service();
        $service->image         = $name;
        $service->title         = $request->input('title');
        $service->description   = $request->input('description');
        $service->show_on_front = $request->input('show_on_front');
        
        if($service->save()){
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
        $service = Service::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$service]);
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
        $service = Service::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$service]);
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
        $service = Service::findOrFail($id);

        if($request->hasFile('image')) {
            File::delete('uploads/services'.'/'.$service->image);
            $image              = $request->file('image');
            $ImageUpload        = Image::make($image)->resize(100, 100);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/services/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = $service->image;
        }
       
        $service->image         = $name;
        $service->title         = $request->input('title');
        $service->description   = $request->input('description');
        $service->show_on_front = $request->input('show_on_front');
        
        if($service->save()){
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
        $service  = Service::findOrFail($id);
        if($service->delete()){
            File::delete('uploads/services'.'/'.$service->image);
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getservice()
    {
        $services = Service::latest()->get();
        return Datatables($services)
            ->addColumn('image',function($service){
                return asset('/uploads/services'.'/'.$service->image); 
            })
            ->addColumn('title',function($service){
                return $service->title; 
            })
            ->addColumn('description',function($service){
                return $service->description; 
            })
            ->addColumn('show_on_front',function($service){
                return $service->show_on_front; 
            })
            ->addColumn('action',function($service){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    
                                        <a class="dropdown-item service-edit"  data-service-id="'.$service->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item service-delete"  data-service-id="'.$service->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
    public function getallservice()
    {
        $service = Service::select('id','image','title')->get();
        return response()->json(['status'=>'success','result'=>$service]);
    }
     public function getallservices()
    {
        $service = Service::select('id','image','title')->get();
        return response()->json(['status'=>'success','result'=>$service]);
    }
}
