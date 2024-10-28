<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SiteContact;

class SiteContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $site_contact = SiteContact::all();
        return view('admin.cms.sitecontact.index')->with(['site_contact'=>$site_contact]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $site_contact             = new SiteContact();
        $site_contact->phone1     = $request->input('phone1');
        $site_contact->phone2     = $request->input('phone2');
        $site_contact->email      = $request->input('email');
        $site_contact->address    = $request->input('address');
       
        
        if($site_contact->save()){
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
        $site_contact = SiteContact::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$site_contact]);
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
        $site_contact = SiteContact::findOrFail($id);

        $site_contact->phone1     = $request->input('phone1');
        $site_contact->phone2     = $request->input('phone2');
        $site_contact->email      = $request->input('email');
        $site_contact->address    = $request->input('address');
        
        if($site_contact->save()){
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
        $site_contact  = SiteContact::findOrFail($id);
        if($site_contact->delete()){
           
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getsitecontact()
    {
        $site_contacts = SiteContact::orderBy('created_at','desc')->select('site_contacts.*');
        return Datatables($site_contacts)
           
            ->addColumn('phone1',function($site_contact){
                return $site_contact->phone1; 
            })
            ->addColumn('phone2',function($site_contact){
                if($site_contact->phone2){
                    return $site_contact->phone2; 
                }else{
                    return "No Phone 2";
                }
            })
            ->addColumn('email',function($site_contact){
                return $site_contact->email; 
            })
            ->addColumn('address',function($site_contact){
                return $site_contact->address; 
            })
           
            ->addColumn('action',function($site_contact){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    
                                        <a class="dropdown-item site-contact-edit"  data-site-contact-id="'.$site_contact->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item site-contact-delete"  data-site-contact-id="'.$site_contact->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
}
