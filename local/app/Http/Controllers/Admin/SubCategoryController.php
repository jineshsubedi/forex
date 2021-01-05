<?php

namespace App\Http\Controllers\Admin;

use Auth;
use File;
use SweetAlert;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$data['filter_category'] = '';
    	$url = url('backend/sub_category?');

        $sub_categories = SubCategory::orderBy('title', 'asc');
    	if($request->filter_category){
    		$sub_categories = $sub_categories->where('category_id', $request->filter_category);
    		$url .= 'filter_category='.$request->filter_category;
    		$data['filter_category'] = $request->filter_category;
    	}
        $sub_categories = $sub_categories->paginate(50)->setPath($url);
    	$categories = Category::orderBy('title','asc')->get();
        return view('admin.subcategory.index', compact('categories', 'sub_categories'))->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$categories = Category::orderBy('title', 'asc')->get();
        return view('admin.subcategory.create', compact('categories'));
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
        	'category_id' => 'required|integer',
            'title.*' => 'required',
            'slug.*' => 'required',
            
        ],[
        	'category_id' => 'Category is Required',
        	'title.*.required' => 'Title Is Rquired',
        	'slug.*.required' => 'Slug Is Rquired, Click Button to generate',
        ]);
        for($i=0;$i<count($request->title);$i++)
        {
        	$data = [
	            'title' => $request->title[$i],
	            'slug' => $request->slug[$i],
	            'category_id' => $request->category_id,
	        ];
	        SubCategory::create($data);
        }
        alert()->success('Success', 'Sub Category added successfully!');
        return redirect()->route('sub_category.index');
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
    	$categories = Category::orderBy('title', 'asc')->get();
        $subcategory = SubCategory::findOrFail($id);
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
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
            'category_id' => 'required',
            'slug' => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
        ];
        SubCategory::find($id)->update($data);
        alert()->success('Success', 'Sub Category Detail updated!');
        return redirect()->route('sub_category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = SubCategory::findOrFail($id);
        $category->delete();
        alert()->success('Success', 'Sub Category Deleted Successfully!!');
        return redirect()->route('sub_category.index');
    }
}
