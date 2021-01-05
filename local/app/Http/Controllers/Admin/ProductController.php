<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Models\Item;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\MainSubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductAttachment;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(20);
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('title','asc')->get();
        return view('admin.product.create', compact('categories'));
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
            'slug' => 'required|unique:products,slug',
            'category_id' => 'required',
            'sub_category_id' => 'sometimes',
            'main_category_id' => 'sometimes',
            'description' => 'required',
            'featured' => 'required',
            'price' => 'required',
            'new' => 'required',
            'brand' => 'sometimes',
            'inventory' => 'required',
            'image' => 'required',
            'image.*' => 'mimes:jpg,png,jpeg,gif|max:2048'
        ],[
            'image.required' => 'Please add product image',
        ]);
        $data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'featured' => $request->featured,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'main_category_id' => $request->main_category_id,
            'description' => $request->description,
            'price' => $request->price,
            'new' => $request->new,
            'brand' => $request->brand,
            'inventory' => $request->inventory,
        ];
        $product = Product::create($data);

        for($i=0;$i<count($request->image);$i++)
        {
            if($request->image)
            {
                $file = $request->image[$i];
                $ext = strtolower($file->getClientOriginalExtension()); 
                $file_name = 'product/'.Str::random(10).strtolower($file->GetClientOriginalName());
                $file->move(DIR_IMAGE.'/product/',$file_name);

                $imageData = [
                    'product_id' => $product->id,
                    'file_name' => $file_name
                ];
                ProductAttachment::create($imageData);
            }
        }

        alert()->success('Success', 'Product Created!');
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $attachments = ProductAttachment::where('product_id', $product->id)->get();
        return view('admin.product.view', compact('product', 'attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('title','asc')->get();
        $sub_categories = SubCategory::where('category_id', $product->category_id)->orderBy('title','asc')->get();
        $main_categories = MainSubCategory::where('sub_category_id', $product->sub_category_id)->orderBy('title','asc')->get();
        $attachments = ProductAttachment::where('product_id', $product->id)->get();
        return view('admin.product.edit', compact('product', 'categories', 'sub_categories', 'main_categories', 'attachments'));
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
            'slug' => 'required|unique:products,slug,'.$id,
            'category_id' => 'required',
            'sub_category_id' => 'sometimes',
            'main_category_id' => 'sometimes',
            'description' => 'required',
            'featured' => 'required',
            'price' => 'required',
            'new' => 'required',
            'brand' => 'sometimes',
            'inventory' => 'required',
            'image.*' => 'required|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'main_category_id' => $request->main_category_id,
            'description' => $request->description,
            'featured' => $request->featured,
            'price' => $request->price,
            'new' => $request->new,
            'brand' => $request->brand,
            'inventory' => $request->inventory,
        ];
        $product = Product::findOrFail($id)->update($data);
        if(isset($request->image))
        {
            for($i=0;$i<count($request->image);$i++)
            {
                if($request->image)
                {
                    $file = $request->image[$i];
                    $ext = strtolower($file->getClientOriginalExtension()); 
                    $file_name = 'product/'.Str::random(10).strtolower($file->GetClientOriginalName());
                    $file->move(DIR_IMAGE.'/product/',$file_name);

                    $imageData = [
                        'product_id' => $id,
                        'file_name' => $file_name
                    ];
                    ProductAttachment::create($imageData);
                }
            }
        }

        alert()->success('Success', 'Product Updated!');
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $attachments = ProductAttachment::where('product_id', $id)->get();
        foreach($attachments as $attachment)
        {
            if(isset($attachment->file_name)){
                if(File::exists(DIR_IMAGE.$attachment->file_name)) {
                    File::delete(DIR_IMAGE.$attachment->file_name);
                }
            }
            ProductAttachment::find($attachment->id)->delete();
        }
        $product->delete();
        alert()->success('Success', 'Product Deleted Successfully!');
        return redirect()->route('blog.index');
    }

    public function removeAttachment(Request $request)
    {
        $attachment = ProductAttachment::findOrFail($request->id);
        if(isset($attachment->file_name)){
            if(File::exists(DIR_IMAGE.$attachment->file_name)) {
                File::delete(DIR_IMAGE.$attachment->file_name);
            }
        }
        $attachment->delete();
        return $request->id;
    }
}
