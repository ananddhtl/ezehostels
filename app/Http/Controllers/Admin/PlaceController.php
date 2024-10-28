<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Place;
use App\Model\City;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $place = Place::all();
        return view('admin.cms.place.index')->with(['place'=>$place]);
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
        foreach ($request->input('place') as  $value) {
            $place          = new Place();
            $place->title   = $value;
            $place->slug    = str_slug($value);
            $place->city_id = $request->input('city');
            $place->save();
        }
        return response()->json(['status'=>'success']);
    
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
        $place = Place::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$place]);
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
        $p = $request->input('place');
        // dd($c[0]);
        $place           = Place::findOrFail($id);
        $place->title    = $p[0];
        $place->slug     = str_slug($p[0]);
        
        if($place->save()){
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
        $place  = Place::findOrFail($id);
        if($place->delete()){
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getplace()
    {
        $places = Place::latest()->get();
        return Datatables($places)
        ->addColumn('city',function($place){
            return $place->city->title; 
        })
            ->addColumn('title',function($place){
                return $place->title; 
            })
            ->addColumn('action',function($place){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item place-edit"  data-place-id="'.$place->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item place-delete"  data-place-id="'.$place->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
    public function getallplace()
    {
        $place = Place::select('id','city_id','title')->get();
        return response()->json(['status'=>'success','result'=>$place]);
    }
    public function getplacebycityid($city_title)
    {
        $city   = City::where('title',$city_title)->first();
        $p      = Place::where('city_id',$city->id)->select('id','title')->get();
        return response()->json(['status'=>'success','result'=>$p]);
    }
}
