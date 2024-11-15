<?php

namespace App\Http\Controllers\Admin;

use App\Model\City;
use App\Model\Cityad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cityad = Cityad::all();
      
        return view('admin.cms.cityads.index')->with(['cityad'=>$cityad]);
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
            $destinationPath    = 'uploads/cityads/';
            $image->move($destinationPath,$name);
        }else{
            $name = '';
        }

        $cityad = new Cityad();
        $cityad->cityid = $request->input('cityid');
        $cityad->ads_link = $request->input('ads_link');
        $cityad->image = $name;

        if($cityad->save()){
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cityad = Cityad::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$cityad]);

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
       
        $cityad = Cityad::findOrFail($id);
        $name = $cityad->image;
    
        if ($request->hasFile('image')) {
         
            $filePath = public_path('uploads/cityads/' . $cityad->image);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
    
           
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/cityads/');
    
           
            $image->move($destinationPath, $name);
        }
    
     
        $cityad->cityid = $request->input('cityid');
        $cityad->ads_link = $request->input('ads_link');
        $cityad->image = $name;
    
        if ($cityad->save()) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
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
        $cityad = Cityad::findOrFail($id);
        if($cityad->delete()){
            File::delete('uploads/cityads'.'/'.$cityad->image);
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getcityads()
    {
        $cityads = Cityad::orderBy('created_at','desc')->select('*');
        return Datatables($cityads)
            ->addColumn('cityid',function($cityad){
                return $cityad->city['title'];
            })
            ->addColumn('image',function($cityad){
                return asset('/uploads/cityads'.'/'.$cityad->image);
            })
            ->addColumn('ads_link',function($cityad){
                return $cityad->ads_link;
            })
            ->addColumn('action',function($cityad){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                                        <a class="dropdown-item site-ads-edit"  data-site-ads-id="'.$cityad->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item site-ads-delete"  data-site-ads-id="'.$cityad->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
                return $return_html;
            })
            ->make(true);
    }

    public function getallcityad(){
        $cityad = Cityad::select('*')->get();
        return response()->json(['status'=>'success','result'=>$cityad]);
    }
}
