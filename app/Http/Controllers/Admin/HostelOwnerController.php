<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class HostelOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cms.hostelowner.index');
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $hostelowner = User::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$hostelowner]);
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
        
        $hostelowner            = User::findOrFail($id);
        $hostelowner->status    = $request->input('status');
       
        // dd($hostel);
        if($hostelowner->save()){
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
   
    public function gethostelowner()
    {
        $hostelowners = User::orderBy('created_at','desc')
                                ->select('id','type','name','address','phone','hostel_name','hostel_address','status')
                                ->where('type','vendor')
                                ->get();
        return Datatables($hostelowners)
            
            ->addColumn('ownername',function($hostelowner){
                return $hostelowner->name; 
            })
            ->addColumn('address',function($hostelowner){
                return $hostelowner->address; 
            })
           
            ->addColumn('phone',function($hostelowner){
                return $hostelowner->phone; 
            })
           
            ->addColumn('hostelname',function($hostelowner){
                return $hostelowner->hostel_name; 
            })
            ->addColumn('hosteladdress',function($hostelowner){
                return $hostelowner->hostel_address; 
            })
            ->addColumn('status',function($hostelowner){
                return $hostelowner->status; 
            })
           
           
            ->addColumn('action',function($hostelowner){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item hostelowner-edit" data-hostelowner-id="'.$hostelowner->id.'" style="cursor:pointer">Edit</a>
                                        
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
}
