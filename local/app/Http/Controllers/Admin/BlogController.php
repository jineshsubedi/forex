<?php

namespace App\Http\Controllers\Admin;

use Auth;
use File;
use App\Models\Blog;
use App\Models\BlogTag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogs = Blog::orderBy('id', 'desc')->paginate(20);
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        
        $image = '';
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension()); 
            $image = 'blog/'.Str::random(10).strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/blog/',$image);
        }

        $data = [
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'slug' => $request->slug,
            'description' => $request->description,
            'tags' => $request->tags,
            'image' => $image,
        ];
        $blog = Blog::create($data);
        if(isset($blog->id))
        {
            $tags = explode(',', $request->tags);
            foreach($tags as $tag)
            {
                $tdata = [
                    'blog_id' => $blog->id,
                    'title' => $tag
                ];
                \App\Models\BlogTag::create($tdata);
            }

        }
        alert()->success('Success', 'BLog Created!');
        return redirect()->route('blog.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idate(format)
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.view', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.edit', compact('blog'));
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
        $this->validate($request, [
            'title' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'image' => 'sometimes|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        $blog = Blog::findOrFail($id);
        $image = $blog->image;
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension()); 
            $image = 'blog/'.Str::random(10).strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/blog/',$image);

            if(isset($blog->image)){
                if(File::exists(DIR_IMAGE.$blog->image)) {
                    File::delete(DIR_IMAGE.$blog->image);
                }
            }
        }

        $data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'tags' => $request->tags,
            'image' => $image,
        ];
        Blog::find($id)->update($data);
        if(isset($blog->id))
        {
            $tags = BlogTag::where('blog_id', $id)->get();
            foreach($tags as $tag){
                BlogTag::find($tag->id)->delete();
            }
            $tags = explode(',', $request->tags);
            foreach($tags as $tag)
            {
                $tdata = [
                    'blog_id' => $id,
                    'title' => $tag
                ];
                \App\Models\BlogTag::create($tdata);  
            }
        }
        alert()->success('Success', 'BLog Created!');
        return redirect()->route('blog.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BlogTag::where('blog_id', $id)->delete();
        $blog = Blog::findOrFail($id);
        if(isset($blog->image)){
            if(File::exists(DIR_IMAGE.$blog->image)) {
                File::delete(DIR_IMAGE.$blog->image);
            }
        }
        $blog->delete();
        alert()->success('Success', 'Blog Deleted Successfully!');
        return redirect()->route('blog.index');
    }
}
