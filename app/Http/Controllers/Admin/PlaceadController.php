<?php

namespace App\Http\Controllers\Admin;

use App\Model\City;
use App\Model\Placead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaceadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $placead = Placead::all();
        return view('admin.cms.placeads.index')->with(['placead'=>$placead]);

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
            $destinationPath    = 'uploads/placeads/';
            $image->move($destinationPath,$name);
        }else{
            $name = '';
        }

        $placead = new Placead();
        $placead->placeid = $request->input('placeid');
        $placead->ads_link = $request->input('ads_link');
        $placead->image = $name;

        if($placead->save()){
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
        $placead = Placead::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$placead]);

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
        $placead = Placead::findOrFail($id);
        if($request->hasFile('image')) {
            File::delete('uploads/cityads'.'/'.$placead->image);
            $image              = $request->file('image');
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/placeads/';
            $image->move($destinationPath,$name);
        }else{
            $name = $placead->image;
        }

        $placead->city = $request->input('placeid');
        $placead->ads_link = $request->input('ads_link');
        $placead->image = $name;

        if($placead->save()){
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
        $placead = Placead::findOrFail($id);
        if($placead->delete()){
            File::delete('uploads/placeads'.'/'.$placead->image);
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getplaceads(){
        $placeads = Placead::orderBy('id','desc')->select('*');
        return Datatables($placeads)
            ->addColumn('placeid',function($placead){
                return $placead->place->title;
            })
            ->addColumn('image',function($placead){
                return asset('/uploads/placeads'.'/'.$placead->image);
            })
            ->addColumn('ads_link',function($placead){
                return $placead->ads_link;
            })
            ->addColumn('action',function($placead){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                                        <a class="dropdown-item site-ads-edit"  data-site-ads-id="'.$placead->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item site-ads-delete"  data-site-ads-id="'.$placead->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
                return $return_html;
            })
            ->make(true);
    }

    public function getAllplaceads(){
        $placead = Placead::select('*')->get();
        return response()->json(['status'=>'success','result'=>$placead]);
    }

    public function getplaceadsbyplaceid($title){
        $places = City::where('title',$title)->first();
        $place = Placead::where('placeid',$places->id)->select('id','title')->get();
        return response()->json(['status'=>'success','result'=>$place]);

    }
}
