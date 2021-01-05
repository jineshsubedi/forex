<?php

namespace App\Http\Controllers\Admin;

use SweetAlert;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MainSubCategory;
use App\Http\Controllers\Controller;

class MainSubCategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$data['filter_category'] = '';
    	$data['filter_sub_category'] = '';

    	$url = url('backend/sub_category?');

        $main_categories = MainSubCategory::orderBy('title', 'asc');
        $subcategories = SubCategory::orderBy('title','asc');
    	if($request->filter_category){
    		$main_categories = $main_categories->where('category_id', $request->filter_category);
    		$subcategories = $subcategories->where('category_id', $request->filter_category);
    		$url .= 'filter_category='.$request->filter_category;
    		$data['filter_category'] = $request->filter_category;
    	}
    	if($request->filter_sub_category){
    		$main_categories = $main_categories->where('sub_category_id', $request->filter_sub_category);
    		$url .= 'filter_sub_category='.$request->filter_sub_category;
    		$data['filter_sub_category'] = $request->filter_sub_category;
    	}
        $main_categories = $main_categories->paginate(50)->setPath($url);
    	$categories = Category::orderBy('title','asc')->get();
    	$subcategories = $subcategories->get();
        return view('admin.maincategory.index', compact('categories', 'subcategories', 'main_categories'))->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$categories = Category::orderBy('title', 'asc')->get();
        return view('admin.maincategory.create', compact('categories'));
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
        	'sub_category_id' => 'required|integer',
            'title.*' => 'required',
            'slug.*' => 'required',
            
        ],[
        	'category_id' => 'Category is Required',
        	'sub_category_id' => 'Sub Category is Required',
        	'title.*.required' => 'Title Is Rquired',
        	'slug.*.required' => 'Slug Is Rquired, Click Button to generate',
        ]);
        for($i=0;$i<count($request->title);$i++)
        {
        	$data = [
	            'title' => $request->title[$i],
	            'slug' => $request->slug[$i],
	            'category_id' => $request->category_id,
	            'sub_category_id' => $request->sub_category_id,
	        ];
	        MainSubCategory::create($data);
        }
        alert()->success('Success', 'Sub Category added successfully!');
        return redirect()->route('main_category.index');
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
        $maincategory = MainSubCategory::findOrFail($id);
    	$subcategories = SubCategory::where('category_id', $maincategory->category_id)->orderBy('title', 'asc')->get();
        return view('admin.maincategory.edit', compact('maincategory', 'categories', 'subcategories'));
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
            'sub_category_id' => 'required',
            'slug' => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
        ];
        MainSubCategory::find($id)->update($data);
        alert()->success('Success', 'Sub Category Detail updated!');
        return redirect()->route('main_category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = MainSubCategory::findOrFail($id);
        $category->delete();
        alert()->success('Success', 'Sub Category Deleted Successfully!!');
        return redirect()->route('main_category.index');
    }
}
