<?php

namespace App\Http\Controllers\Admin;

use SweetAlert;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('title', 'asc')->paginate(20);
        return view('admin.item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.item.create');
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
            
        ],[
        	'title.*.required' => 'Title Is Rquired',
        	'slug.*.required' => 'Slug Is Rquired, Click Button to generate',
        ]);
        for($i=0;$i<count($request->title);$i++)
        {
        	$data = [
	            'title' => $request->title[$i],
	            'slug' => $request->slug[$i],
	        ];
	        Item::create($data);
        }
        alert()->success('Success', 'Item added successfully!');
        return redirect()->route('item.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $item = Item::findOrFail($id);
        // return view('admin.item.view', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('admin.item.edit', compact('item'));
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
        ]);

        $data = [
            'title' => $request->title,
            'slug' => $request->slug,
        ];
        Item::find($id)->update($data);
        alert()->success('Success', 'Item Detail updated!');
        return redirect()->route('item.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        alert()->success('Success', 'Item Deleted Successfully!!');
        return redirect()->route('item.index');
    }

    public function getItemByProduct(Request $request)
    {
        $product = \App\Models\Product::find($request->product_id);
        $item = Item::find($product->item_id);
        return $product;
    }

}
