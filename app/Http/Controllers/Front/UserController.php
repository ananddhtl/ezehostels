<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Model\Hostel;
use App\Model\HostelPrice;
use App\Model\HostelGallery;
use Image;
use File;
use Illuminate\Support\Facades\Auth;
use App\Model\HostelService;

class UserController extends Controller
{
    public function updateuser(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'address'   => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->input('user_id')],
            'password'  => ['sometimes', 'confirmed'],
        ]);
        
        $id             =   $request->input('user_id');
        $user           =   User::where('id',$id)->first();
        
        $user->name     =   $request->input('name');
        $user->address  =   $request->input('address');
        $user->phone    =   $request->input('phone');
        $user->email    =   $request->input('email');

        if($request->input('password') != ''){
            $user->password = Hash::make($request->input('password'));
            $user->save();
            /* login after update */
            $credentials = array(
                'email'     => $request->input('email'),
                'password'  => $request->input('password')
            );
            if (auth()->attempt($credentials)) {
                return redirect('/user-dashboard')->with('msg','User Updated Successfully !');;
            }
        }else{
            $user->save();
            return redirect('/user-dashboard')->with('msg','User Updated Successfully !');;
        }
    }
    public function updatevendor(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'address'   => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->input('vendor_id')],
            'password'  => ['sometimes', 'confirmed'],
            'hostel_name'      => ['required', 'string', 'max:255'],
            'hostel_address'   => ['required', 'string', 'max:255'],
        ]);
        
        $id               =   $request->input('vendor_id');
        $vendor           =   User::where('id',$id)->first();
        
        $vendor->name     =   $request->input('name');
        $vendor->address  =   $request->input('address');
        $vendor->phone    =   $request->input('phone');
        $vendor->email    =   $request->input('email');
        $vendor->hostel_address    =   $request->input('hostel_address');
        $vendor->hostel_name       =   $request->input('hostel_name');
        $active_tab                =   "profile";
        if($request->input('password') != ''){
            $vendor->password = Hash::make($request->input('password'));
            $vendor->save();
            /* login after update */
            $credentials = array(
                'email'     => $request->input('email'),
                'password'  => $request->input('password')
            );
            if (auth()->attempt($credentials)) {
                return redirect('/user-dashboard')->with(['msg'=>'User Updated Successfully !','active_tab'=>$active_tab]);
            }
        }else{
            $vendor->save();
            return redirect('/user-dashboard')->with(['vendor-msg'=>'User Updated Successfully !','active_tab'=>$active_tab]);
        }
    }

    public function vendorhostelstore(Request $request)
    {
        $request->validate([
            'title'             => ['required', 'string', 'max:255'],
            'description'       => ['required', 'string'],
            'type'              => ['required'],
            'policies'          => ['required'],
            'service'           => ['required'],
            'service.*'         => ['required'],
            'city'              => ['required'],
            'place'             => ['required'],
            'iframe'            => ['sometimes'],
        ]);


        if($request->hasFile('image')) {
            $image              = $request->file('image');
            $ImageUpload        = Image::make($image)->resize(1000, 1000);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/hostels/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = '';
        }
        $hostel                = new Hostel();
        $hostel->image         = $name;
        $hostel->title         = $request->input('title');
        $hostel->price         = $request->input('price');
        $hostel->slug          = str_slug($request->input('title'));
        $hostel->description   = $request->input('description');
        $hostel->type          = $request->input('type');
       
        $hostel->city          = $request->input('city');
        $hostel->place         = $request->input('place');
        $hostel->policies      = $request->input('policies');
        $hostel->vendor_id     = auth::user()->id;
        $hostel->featured      = 'no';
        $hostel->iframe        = $request->input('iframe');
        $active_tab            = "hostel";
        if($hostel->save()){
            foreach ($request->service as $s) {
                $hostel->hostelservices()->save(new HostelService(["service" => $s]));
            }
            return redirect('/user-dashboard')->with(['hostel-add-msg'=>'Hostel Added Successfully !','active_tab'=>$active_tab]);
        }
    }
    public function vendorhosteledit($id)
    {
        $hostel     =   Hostel::findOrFail($id);

        return view('front.vendor.hostel-edit')->with('hostel',$hostel);
    }
    public function vendorhostelupdate(Request $request, $id)
    {

        $hostel     =   Hostel::findOrFail($id);
        $request->validate([
            'title'             => ['required', 'string', 'max:255'],
            'description'       => ['required', 'string'],
            'type'              => ['required'],
            'policies'          => ['required'],
            'service'           => ['sometimes'],
            'service.*'         => ['sometimes'],
            'city'              => ['required'],
            'place'             => ['required'],
            'iframe'            => ['required'],
        ]);


        if($request->hasFile('image')) {
            File::delete('uploads/hostels'.'/'.$hostel->image);
            $image              = $request->file('image');
            $ImageUpload        = Image::make($image)->resize(1000, 1000);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/hostels/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = $hostel->image;
        }
        $hostel->image         = $name;
        $hostel->title         = $request->input('title');
        $hostel->price         = $request->input('price');
        $hostel->slug          = str_slug($request->input('title'));
        $hostel->description   = $request->input('description');
        $hostel->type          = $request->input('type');

        if($request->has('service')){
            $hostel->hostelservices()->delete();
            foreach ($request->service as $s) {
                $hostel->hostelservices()->save(new HostelService(["service" => $s]));
            }
        }
        
        $hostel->city          = $request->input('city');
        $hostel->place         = $request->input('place');
        $hostel->policies      = $request->input('policies');
        $hostel->vendor_id     = $hostel->vendor_id;
        $hostel->featured      = $hostel->featured;
        $hostel->iframe        = $request->input('iframe');
        $active_tab            = "hostel";

        

        if($hostel->save()){
            return redirect('/user-dashboard')->with(['hostel-add-msg'=>'Hostel Updated Successfully !','active_tab'=>$active_tab]);
        }
    }
    public function vendorhosteldelete($id)
    {
        $hostel  = Hostel::findOrFail($id);
        if($hostel->delete()){
            File::delete('uploads/hostels'.'/'.$hostel->image);
            return redirect('/user-dashboard')->with(['hostel-add-msg'=>'Hostel Deleted Successfully !']);
        }else{
            return redirect('/user-dashboard')->with(['hostel-add-msg'=>'Somethings error !']);
        }
    }

    public function vendorhostelgallerystore(Request $request)
    {
        $request->validate([
            'hostel'             => 'required',
        ]);
        if ($image = $request->file('image')) {
            // dd($image);
            foreach ($image as  $value) {
                $destinationPath   = 'uploads/hostelgallery/';
                $name              = time(). rand(0,100) . '.' . $value->getClientOriginalExtension();
                $ImageUpload       = Image::make($value)->resize(1000, 1000);

                $ImageUpload->save($destinationPath.$name);  

                $hostel_gallery             = new HostelGallery();
                $hostel_gallery->hostel_id  = $request->hostel;
                $hostel_gallery->image      = $name;
                $hostel_gallery->save();
            }
        }
        $active_tab   = "gallery";
        return redirect('/user-dashboard')->with(['hostel-gallery-msg'=>'Hostel Gallery Added Successfully !','active_tab'=>$active_tab]);
    }
    public function vendorhostelgalleryedit($id)
    {
        $gallery = HostelGallery::findOrFail($id);
        return view('front.vendor.hostel-gallery-edit')->with('gallery',$gallery);
    }
    public function vendorhostelgalleryupdate(Request $request, $id)
    {
        $request->validate([
            'hostel'   => 'required',
        ]);
        $gallery    =   HostelGallery::findOrFail($id);
        if($request->hasFile('image')) {
            File::delete('uploads/hostelgallery'.'/'.$gallery->image);
            $image              = $request->file('image');
            $ImageUpload        = Image::make($image)->resize(1000, 1000);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/hostelgallery/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = $gallery->image;
        }
        $gallery->hostel_id = $request->hostel;
        $gallery->image     = $name;
        if($gallery->save())
        {
            return redirect('/user-dashboard')->with(['hostel-gallery-msg'=>'Hostel Gallery Image Updated Successfully !']);
        }else
        {
            return redirect('/user-dashboard')->with(['hostel-gallery-msg'=>'Somethings error!']);
        }
    }
    public function vendorhostelgallerydelete($id)
    {
        $gallery  = HostelGallery::findOrFail($id);
        if($gallery->delete()){
            File::delete('uploads/hostelgallery'.'/'.$gallery->image);
            return redirect('/user-dashboard')->with(['hostel-gallery-msg'=>'Hostel Gallery Image Deleted Successfully !']);
        }else{
            return redirect('/user-dashboard')->with(['hostel-gallery-msg'=>'Somethings error !']);
        }
    }

    public function vendorhostelpricingstore(Request $request)
    {
        $request->validate([
            'room_type' => 'required',
            'pricing'   => 'required',
            'pricing.*' => 'required',
            'hostel'    =>  'required',
            'price'     =>  'required',
            'price.*'   =>  'required'
        ]);
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
        $active_tab   = "pricing";
       
        if($hostel_price->save()){
            return redirect('/user-dashboard')->with(['hostel-pricing-msg'=>'Hostel Pricing Added Successfully !','active_tab'=>$active_tab]);
        }
    }
    public function vendorhostelpricingedit($id)
    {
        $pricing    =   HostelPrice::findOrFail($id);
        return view('front.vendor.hostel-pricing-edit')->with('pricing',$pricing);
    }
    public function vendorhostelpricingupdate(Request $request, $id)
    {
        $request->validate([
            'room_type' => 'required',
            'pricing'   => 'required',
            'pricing.*' => 'required',
            'hostel'    =>  'required',
            'price'     =>  'required',
            'price.*'   =>  'required'
        ]);
        $hostel_price                   = HostelPrice::findOrFail($id);
        $hostel_price->hostel_id        = $request->input('hostel');
        $hostel_price->room_type        = $request->input('room_type');                
        $hostel_price->available_room   = $request->input('available_room'); 
       
        $pricing                        = $request->input('pricing');
        $price                          = $request->input('price');  
        $main                           = array_combine($pricing,$price);
        
        $hostel_price->pricing          = json_encode($main);
        $active_tab   = "pricing";
       
        if($hostel_price->save()){
            return redirect('/user-dashboard')->with(['hostel-pricing-msg'=>'Hostel Pricing Updated Successfully !','active_tab'=>$active_tab]);
        }
    }
    public function vendorhostelpricingdelete(Request $request, $id)
    {
        $hostel_price    = HostelPrice::findOrFail($id);
        if($hostel_price->delete()){
            return redirect('/user-dashboard')->with(['hostel-pricing-msg'=>'Hostel Pricing Updated Successfully !']);
        }else{
            return redirect('/user-dashboard')->with(['hostel-pricing-msg'=>'Hostel Pricing Updated Successfully !']);
        }
    }

    public function getallvendorhostels($id)
    {
        $hostels = Hostel::where('vendor_id',$id)->get();
        return view('front.vendor.hostel')->with('hostels',$hostels);
    }
    public function getallvendorhostelsgallery($id)
    {
        $hostels = Hostel::where('vendor_id',$id)->get();
        return view('front.vendor.hostel-gallery')->with('hostels',$hostels);
    }
    public function getallvendorhostelspricing($id)
    {
        $hostels = Hostel::where('vendor_id',$id)->get();
        return view('front.vendor.hostel-pricing')->with('hostels',$hostels);
    }
}
