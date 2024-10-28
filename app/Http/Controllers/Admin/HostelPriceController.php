<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\HostelPrice;

class HostelPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cms.hostelprice.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'room_type' => 'required|unique:hostel_prices',
        //     'pricing'   => 'required|unique:hostel_prices',
        //     'hostel_id' =>  'required',
        //     'price'     =>  'required'
        // ]);
        $hostel_price                   = new HostelPrice();
        $hostel_price->hostel_id        = $request->input('hostel');
        $hostel_price->room_type        = $request->input('room_type');                
        $hostel_price->available_room   = $request->input('available_room'); 
        // $hostel_price->price        = $request->input('price');
        // dd($pricing);
        $pricing                        = $request->input('pricing');
        $price                          = $request->input('price');  
        $main                           = array_combine($pricing,$price);
        // dd(json_encode($main));
        $hostel_price->pricing          = json_encode($main);

       
        if($hostel_price->save()){
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
        $hostel_price = HostelPrice::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$hostel_price]);
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
        $hostel_price = HostelPrice::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$hostel_price]);
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
        $hostel_price               = HostelPrice::findOrFail($id);
        $hostel_price->hostel_id    = $request->input('hostel');
        $hostel_price->room_type    = $request->input('room_type'); 
        $hostel_price->available_room   = $request->input('available_room');                
        $hostel_price->hostel_id    = $request->input('hostel');
        $hostel_price->room_type    = $request->input('room_type');                
        // $hostel_price->pricing      = $request->input('pricing'); 
        // $hostel_price->price        = $request->input('price');
        // dd($pricing);
        $pricing                    = $request->input('pricing');
        $price                      = $request->input('price');  
        $main                       = array_combine($pricing,$price);
        // dd(json_encode($main));
        $hostel_price->pricing      = json_encode($main);

       
        if($hostel_price->save()){
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
        $hostel_price  = HostelPrice::findOrFail($id);
        if($hostel_price->delete()){
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function gethostelprice()
    {
        $hostel_prices = HostelPrice::latest()->get();
        return Datatables($hostel_prices)
            ->addColumn('hostel',function($hostel_price){
                return $hostel_price->hostel->title; 
            })
            ->addColumn('room_type',function($hostel_price){
                return $hostel_price->room_type; 
            })
            ->addColumn('available_room',function($hostel_price){
                return $hostel_price->available_room; 
            })
            ->addColumn('pricing',function($hostel_price){
                return $hostel_price->pricing; 
            })
            
            
            ->addColumn('action',function($hostel_price){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    
                                        <a class="dropdown-item hostel-price-edit"  data-hostel-price-id="'.$hostel_price->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item hostel-price-delete"  data-hostel-price-id="'.$hostel_price->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
    public function getallhostel()
    {
        $hostel = HostelPrice::select('id','title')->get();
        return response()->json(['status'=>'success','hostels'=>$hostel]);
    }
}
