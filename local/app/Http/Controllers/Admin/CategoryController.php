<?php

namespace App\Http\Controllers\Admin;

use Auth;
use File;
use SweetAlert;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('title', 'asc')->paginate(20);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'title.*' => 'required',
            'slug.*' => 'required',
            'image.*' => 'sometimes|mimes:jpg,png,jpeg|max:2048',
            'featured.*' => 'required',
        ],[
        	'title.*.required' => 'Title Is Rquired',
        	'slug.*.required' => 'Slug Is Rquired, Click Button to generate',
        	'image.*.mimes' => 'Image must be JPG,PNG,JPEG',
        	'image.*.max' => 'Image must be of Size 2MB or less',
        ]);
        
        for($i=0;$i<count($request->title);$i++)
        {
        	$image = null;
        	//handle image
        	if($request->hasfile('image.'.$i))
	        {
	            $file = $request->file('image.'.$i);
	            $ext = strtolower($file->getClientOriginalExtension()); 
	            $image = 'category/'.Str::random(10).strtolower($file->GetClientOriginalName());
	            $file->move(DIR_IMAGE.'/category/',$image);
	        }
        	//save image
        	

        	$data = [
	            'title' => $request->title[$i],
	            'slug' => $request->slug[$i],
	            'image' => $image,
	            'featured' => $request->featured[$i]
	        ];
	        Category::create($data);
        }
        alert()->success('Success', 'Category added successfully!');
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
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
            'image' => 'sometimes|mimes:jpg,png,jpeg|max:2048',
            'featured' => 'required',
        ]);
        $category = Category::findOrFail($id);
        $image = $category->image;
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension()); 
            $image = 'category/'.Str::random(10).strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/category/',$image);

            if(isset($category->image)){
	            if(File::exists(DIR_IMAGE.$category->image)) {
	                File::delete(DIR_IMAGE.$category->image);
	            }
	        }
        }

        $data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'image' => $image,
            'featured' => $request->featured,
        ];
        Category::find($id)->update($data);
        alert()->success('Success', 'Category Detail updated!');
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if(isset($category->image)){
            if(File::exists(DIR_IMAGE.$category->image)) {
                File::delete(DIR_IMAGE.$category->image);
            }
        }
        $category->delete();
        alert()->success('Success', 'Category Deleted Successfully!!');
        return redirect()->route('category.index');
    }

    
}
