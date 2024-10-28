<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Logo;
use Image;
use File;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logo = Logo::all();
        return view('admin.cms.logo.index')->with(['logo'=>$logo]);
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
            $ImageUpload        = Image::make($image)->resize(200, 200);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/';
            $ImageUpload->save($destinationPath.$name);  
        }
        $logo = new Logo();
        $logo->image = $name;
        
        if($logo->save()){
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
        $logo = Logo::findOrFail($id);
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
        $logo = Logo::findOrFail($id);
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
        $logo = Logo::findOrFail($id);
        
        if($request->hasFile('image')) {
            File::delete('uploads'.'/'.$logo->image);
            $image              = $request->file('image');
            $ImageUpload        = Image::make($image)->resize(200, 200);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = $logo->image;
        }
        $logo->image = $name;
        
        if($logo->save()){
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
        $logo  = Logo::findOrFail($id);
        if($logo->delete()){
            File::delete('uploads'.'/'.$logo->image);
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getLogo()
    {
        $logos = Logo::orderBy('created_at','desc')->select('logos.*');
        return Datatables($logos)
            ->addColumn('image',function($logo){
                return asset('/uploads'.'/'.$logo->image); 
            })
            ->addColumn('action',function($logo){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item logo-detail"  data-logo-id="'.$logo->id.'">View Detail</a>
                                        <a class="dropdown-item logo-edit"  data-logo-id="'.$logo->id.'">Edit</a>
                                        <a class="dropdown-item logo-delete"  data-logo-id="'.$logo->id.'">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
}
