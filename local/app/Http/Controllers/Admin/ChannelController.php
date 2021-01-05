<?php

namespace App\Http\Controllers\Admin;

use File;
use \Carbon\Carbon;
use App\Models\Channel;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    public function index(Request $request)
    {
    	$channels = Channel::orderBy('id', 'asc')->paginate(50);
    	return view('admin.channel.index', compact('channels'));
    }
    public function create()
    {
    	$data['product'] = Product::orderBy('title','asc')->with('product_attachment')->get();
    	return view('admin.channel.create')->with('data', $data);
    }
    public function store(Request $request)
    {

    	$this->validate($request, [
    		'title' => 'required',
    		'status' => 'required',
    		'start_date' => 'required',
    		'end_date' => 'required',
    		'product.*' => 'required',
    		'image' => 'sometimes',
    	]);
        
    	$file_name = '';
    	if($request->image)
        {
            $file = $request->image;
            $ext = strtolower($file->getClientOriginalExtension()); 
            $file_name = 'channel/'.Str::random(10).strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/channel/',$file_name);
        }
        $product = '';
        if(isset($request->product))
        {
            $product = json_encode($request->product);
        }
    	$data = [
    		'title' => $request->title,
    		'status' => $request->status,
    		'start_date' => $request->start_date,
    		'end_date' => $request->end_date,
    		'image' => $file_name,
    		'product' => $product
    	];
    	$channel = Channel::create($data);
    	alert()->success('Success', 'Channel Created!');
        return redirect()->route('channel.index');
    }
    public function edit($id)
    {
    	$data['channel'] = Channel::findOrFail($id);
    	$data['items'] = $data['channel']->product != NULL ? json_decode($data['channel']->product) : [0];
    	$data['product'] = Product::orderBy('title','asc')->get();
    	return view('admin.channel.edit')->with('data', $data);
    }
    public function update($id, Request $request)
    {
    	$this->validate($request, [
    		'title' => 'required',
    		'status' => 'required',
    		'start_date' => 'required',
    		'end_date' => 'required',
    		'product.*' => 'required',
    		'image' => 'sometimes',
    	]);
    	$channel = Channel::findOrFail($id);
    	$file_name = $channel->image;
    	if($request->image)
        {
        	if(isset($channel->image)){
                if(File::exists(DIR_IMAGE.$channel->image)) {
                    File::delete(DIR_IMAGE.$channel->image);
                }
            }
            $file = $request->image;
            $ext = strtolower($file->getClientOriginalExtension()); 
            $file_name = 'channel/'.Str::random(10).strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/channel/',$file_name);
        }
        $product = NULL;
        if(isset($request->product))
        {
            $product = json_encode($request->product);
        }
    	$data = [
    		'title' => $request->title,
    		'status' => $request->status,
    		'start_date' => $request->start_date,
    		'end_date' => $request->end_date,
    		'image' => $file_name,
    		'product' => $product
    	];
    	$channel->update($data);
    	alert()->success('Success', 'Channel Updated!');
        return redirect()->route('channel.index');
    }
    public function destroy($id)
    {
    	$channel = Channel::findOrFail($id);
    	if(isset($channel->image)){
            if(File::exists(DIR_IMAGE.$channel->image)) {
                File::delete(DIR_IMAGE.$channel->image);
            }
        }
    	$channel->delete();
    	alert()->success('Success', 'Channel Deleted!');
        return redirect()->route('channel.index');
    }
}
