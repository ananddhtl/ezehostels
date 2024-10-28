<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\City;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $city = City::all();
        return view('admin.cms.city.index')->with(['city'=>$city]);
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
        foreach ($request->input('city') as  $value) {
            $city           = new City();
            $city->title    = $value;
            $city->slug     = str_slug($value);
            $city->save();
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
        $city = City::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$city]);
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
        // dd($request->all());
        $c = $request->input('city');
        // dd($c[0]);
        $city                   = City::findOrFail($id);
        $city->title            = $c[0];
        $city->slug             = str_slug($c[0]);
        $city->show_on_front    = $request->input('show_on_front');
        
        if($city->save()){
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
        $city  = City::findOrFail($id);
        if($city->delete()){
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getcity()
    {
        $cities = City::latest()->get();
        return Datatables($cities)
            ->addColumn('title',function($city){
                return $city->title; 
            })
            ->addColumn('action',function($city){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item city-edit"  data-city-id="'.$city->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item city-delete"  data-city-id="'.$city->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
    public function getallcity()
    {
        $city = City::select('id','title')->get();
        return response()->json(['status'=>'success','result'=>$city]);
    }
     public function getallcities()
    {
        $city = City::select('id','title')->get();
        return response()->json(['status'=>'success','result'=>$city]);
    }
}
