<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MetaKey;

class MetaKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cms.metakey.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $metakey                = new MetaKey();
        
        $metakey->meta_key      = $request->input('meta_key');
        $metakey->description   = $request->input('description');
        $metakey->search_result_description   = $request->input('search_result_description');
        if($request->has('city')):
            $metakey->city_id   = $request->input('city');
        endif;
        if($request->has('place')):
            $metakey->place_id  =   $request->input('place');
        endif;
        if($request->has('hostel')):
            $metakey->hostel_id =   $request->input('hostel');
        endif;
       
        
        if($metakey->save()){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }
    
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
        $metakey = MetaKey::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$metakey]);
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
        $metakey                = MetaKey::findOrFail($id);

       
        $metakey->meta_key      = $request->input('meta_key');
        $metakey->description   = $request->input('description');
        $metakey->search_result_description   = $request->input('search_result_description');

        if($request->has('city')):
            $metakey->city_id   = $request->input('city');
        endif;
        if($request->has('place')):
            $metakey->place_id  =   $request->input('place');
        endif;
        if($request->has('hostel')):
            $metakey->hostel_id =   $request->input('hostel');
        endif;
        
        if($metakey->save()){
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
        $metakey  = MetaKey::findOrFail($id);
        if($metakey->delete()){
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getmetakey()
    {
        $metakeys = MetaKey::select('meta_keys.*')->get();
        return Datatables($metakeys)
            ->addColumn('city',function($metakey){
                if($metakey->city_id):
                    return $metakey->city->title; 
                endif;
            })
            ->addColumn('place',function($metakey){
                if($metakey->place_id):
                    return $metakey->place->title; 
                endif;
            })
            ->addColumn('hostel',function($metakey){
                if($metakey->hostel_id):
                    return $metakey->hostel->title; 
                endif;
            })
            ->addColumn('metakey',function($metakey){
                return $metakey->meta_key; 
            })
            ->addColumn('description',function($metakey){
                return $metakey->description; 
            })
            ->addColumn('search_result_description',function($metakey){
                return $metakey->search_result_description; 
            })
            ->addColumn('action',function($metakey){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    
                                        <a class="dropdown-item metakey-edit"  data-metakey-id="'.$metakey->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item metakey-delete"  data-metakey-id="'.$metakey->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
    
}
