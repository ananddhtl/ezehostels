<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Blog;
use Image;
use File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cms.blog.index');
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
            $destinationPath    = 'uploads/blogs/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = '';
        }
        $blog                = new Blog();
        $blog->image         = $name;
        $blog->title         = $request->input('title');
        $blog->slug          = str_slug($request->input('title'));
        $blog->description   = $request->input('description');
        $blog->date          = $request->input('date');
        
        if($blog->save()){
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
        $blog = Blog::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$blog]);
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
        $blog = Blog::findOrFail($id);
        return response()->json(['status'=>'success','result'=>$blog]);
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
        $blog = Blog::findOrFail($id);

        if($request->hasFile('image')) {
            File::delete('uploads/blogs'.'/'.$blog->image);
            $image              = $request->file('image');
            $ImageUpload        = Image::make($image)->resize(1000, 1000);
            $name               = time().'.' . $image->getClientOriginalExtension();
            $destinationPath    = 'uploads/blogs/';
            $ImageUpload->save($destinationPath.$name);  
        }else{
            $name = $blog->image;
        }
       
        $blog->image         = $name;
        $blog->title         = $request->input('title');
        $blog->slug          = str_slug($request->input('title'));
        $blog->description   = $request->input('description');
        $blog->description   = $request->input('description');
        $blog->date          = $request->input('date');
        
        if($blog->save()){
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
        $blog  = Blog::findOrFail($id);
        if($blog->delete()){
            File::delete('uploads/blogs'.'/'.$blog->image);
            return response()->json(array('status'=>'success'));
        }else{
            return response()->json(array('status'=>'error'));
        }
    }

    public function getblog()
    {
        $blogs = Blog::latest()->get();
        return Datatables($blogs)
            ->addColumn('image',function($blog){
                return asset('/uploads/blogs'.'/'.$blog->image); 
            })
            ->addColumn('title',function($blog){
                return $blog->title; 
            })
            ->addColumn('description',function($blog){
                return $blog->description; 
            })
            ->addColumn('date',function($blog){
                return $blog->date; 
            })
            ->addColumn('action',function($blog){
                $return_html = '<div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-align-center fa-2x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    
                                        <a class="dropdown-item blog-edit"  data-blog-id="'.$blog->id.'" style="cursor:pointer">Edit</a>
                                        <a class="dropdown-item blog-delete"  data-blog-id="'.$blog->id.'" style="cursor:pointer">Delete</a>
                                    </div>
                                </div>';
            return $return_html;
            })
            ->make(true);
    }
    public function getallblog()
    {
        $blog = Blog::select('id','title')->get();
        return response()->json(['status'=>'success','result'=>$blog]);
    }
}

