<?php

namespace App\Http\Controllers\Admin;

use File;
use SweetAlert;
use App\Models\Item;
use App\Models\Vendor;
use App\Models\VendorOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::orderBy('name')->paginate(20);
        return view('admin.vendor.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vendor.create');
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
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'sometimes',
            'image' => 'sometimes|mimes:jpg,png,jpeg,gif'
        ]);
        $image = '';
        
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension()); 
            $image = 'vendor/'.strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/vendor/',$image);
        }

        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $image,
        ];
        Vendor::create($data);
        alert()->success('Success', 'Vendor added successfully!');
        return redirect()->route('vendor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendor.view', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendor.edit', compact('vendor'));
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
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'sometimes',
            'image' => 'sometimes|mimes:jpg,png,jpeg,gif'
        ]);
        $vendor = Vendor::find($id);
        $image = '';
        if(isset($vendor->image))
        {
            $image = $vendor->image;
            if($request->hasfile('image'))
            {
                $file = $request->file('image');
                $ext = strtolower($file->getClientOriginalExtension()); 
                $image = 'vendor/'.strtolower($file->GetClientOriginalName());
                $file->move(DIR_IMAGE.'/vendor/',$image);
                if(isset($vendor->image)){
                    if(File::exists(DIR_IMAGE.$vendor->image)) {
                        File::delete(DIR_IMAGE.$vendor->image);
                    }
                }
            }
        }

        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $image,
        ];
        Vendor::find($id)->update($data);
        alert()->success('Success', 'Vendor Detail updated!');
        return redirect()->route('vendor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        if(isset($vendor->image)){
            if(File::exists(DIR_IMAGE.$vendor->image)) {
                File::delete(DIR_IMAGE.$vendor->image);
            }
        }
        $vendor->delete();
        alert()->success('Success', 'Vendor Deleted Successfully!!');
        return redirect()->route('vendor.index');
    }

    public function indexOrder($id)
    {
        $vendor = Vendor::findOrFail($id);
        $orders = VendorOrder::where('vendor_id', $id)->paginate(100);
        return view('admin.vendor.order', compact('vendor', 'orders'));
    }
    public function createOrder($id)
    {
        $vendor = Vendor::findOrFail($id);
        $items = Item::orderBy('title','asc')->get();
        return view('admin.vendor.order_create', compact('vendor', 'items'));
    }
    public function saveOrder(Request $request)
    {
        $this->validate($request, [
            'vendor_id' => 'required',
            'item_id' => 'required',
            'date' => 'required',
            'quantity' => 'required',
            'unit_cost' => 'required',
            'total_cost' => 'required',
        ]);
        $item_id = $request->item_id;
        if($request->item_id == 0)
        {
            $data =[
                'title' => $request->title,
                'slug' => $request->slug,
            ];
            $item = \App\Models\Item::create($data);
            $item_id = $item->id;
        }
        $data = [
            'vendor_id' => $request->vendor_id,
            'item_id' => $item_id,
            'date' => $request->date,
            'quantity' => $request->quantity,
            'unit_cost' => $request->unit_cost,
            'total_cost' => $request->total_cost,
        ];
        \App\Models\VendorOrder::create($data);
        alert()->success('Success', 'Order Added Successfully!!');
        if($request->submitAction == 1){
            return redirect()->back();
        }
        if($request->submitAction == 2){
            return redirect()->route('vendor.index');
        }
    }
    public function deleteOrder($id)
    {
        \App\Models\VendorOrder::find($id)->delete();
        alert()->success('Success', 'Order Deleted Successfully!!');
        return redirect()->back();
    }
}
