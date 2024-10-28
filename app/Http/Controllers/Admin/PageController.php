<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Page;
use Image;
use File;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cms.page.index');
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
            $ImageUpload        = Image::make($image)->resize(1000, 1000);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/pages/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = '';
        }
        if($request->hasFile('background_image')) {
            $background_image       = $request->file('background_image');
            $BackgroundImageUpload  = Image::make($background_image)->resize(1000, 1000);
            $background_name        = time().rand(0,100).'.' . $background_image->getClientOriginalExtension();
            $destinationPath        = 'uploads/pages/';
            $BackgroundImageUpload->save($destinationPath.$background_name);  
        }else{
            $background_name = '';
        }
        $page                   = new Page();
        $page->image            = $name;
        $page->background_image = $background_name;
        $page->title            = $request->input('title');
        $page->slug             = str_slug($request->input('title'));
        $page->subtitle         = $request->input('subtitle');
        $page->description      = $request->input('description');
        
        
        if($page->save()){
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
        $page = Page::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$page]);
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
        $page = Page::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$page]);
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
        $page = Page::findOrFail($id);
       
        if($request->hasFile('image')) {
             File::delete('uploads/pages'.'/'.$page->image);
            $image              = $request->file('image');
            $ImageUpload        = Image::make($image)->resize(1000, 1000);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/pages/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = $page->image;
        }
        if($request->hasFile('background_image')) {
             File::delete('uploads/pages'.'/'.$page->background_image);
            $background_image       = $request->file('background_image');
            $BackgroundImageUpload  = Image::make($background_image)->resize(1000, 1000);
            $background_name        = time().rand(0,100).'.' . $background_image->getClientOriginalExtension();
            $destinationPath        = 'uploads/pages/';
            $BackgroundImageUpload->save($destinationPath.$background_name);  
        }else{
            $background_name = $page->background_image;
        }
        $page->image            = $name;
        $page->background_image = $background_name;
        $page->title            = $request->input('title');
        $page->slug             = str_slug($request->input('title'));
        $page->subtitle         = $request->input('subtitle');
        $page->description      = $request->input('description');

        if($page->save()){
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
        $page  = Page::findOrFail($id);
        if($page->delete()){
            File::delete('uploads/pages'.'/'.$page->image);
            if($page->background_image){
                File::delete('uploads/pages'.'/'.$page->background_image);
            }
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getblog()
    {
        $pages = Page::latest()->get();
        return Datatables($pages)
            ->addColumn('image',function($page){
                return asset('/uploads/pages'.'/'.$page->image); 
            })
            ->addColumn('background_image',function($page){
                return asset('/uploads/pages'.'/'.$page->background_image); 
            })
            ->addColumn('title',function($page){
                return $page->title; 
            })
            ->addColumn('slug',function($page){
                return $page->slug; 
            })
            ->addColumn('subtitle',function($page){
                return $page->subtitle; 
            })
            ->addColumn('description',function($page){
                return $page->description; 
            })
           
            ->addColumn('action',function($page){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    
                                        <a class="dropdown-item page-edit"  data-page-id="'.$page->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item page-delete"  data-page-id="'.$page->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
    
}
