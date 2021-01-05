<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Models\Group;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    public function index(Request $request)
    {
    	$groups = Group::orderBy('order', 'asc')->paginate(50);
    	return view('admin.group.index', compact('groups'));
    }
    public function create()
    {
    	$data['category'] = Category::orderBy('title','asc')->get();
    	return view('admin.group.create')->with('data', $data);
    }
    public function store(Request $request)
    {
    	$this->validate($request, [
    		'title' => 'required',
    		'slug' => 'required',
    		'category.*' => 'required',
    		'order' => 'required',
    		'description' => 'sometimes',
    		'image' => 'sometimes',
    	]);
    	$file_name = '';
    	if($request->image)
            {
                $file = $request->image;
                $ext = strtolower($file->getClientOriginalExtension()); 
                $file_name = 'group/'.Str::random(10).strtolower($file->GetClientOriginalName());
                $file->move(DIR_IMAGE.'/group/',$file_name);
            }
    	$data = [
    		'title' => $request->title,
    		'slug' => $request->slug,
    		'order' => $request->order,
    		'description' => $request->description,
    		'image' => $file_name,
    		'category' => json_encode($request->category)
    	];
    	$group = Group::create($data);
    	alert()->success('Success', 'Group Created!');
        return redirect()->route('group.index');
    }
    public function edit($id)
    {
    	$data['group'] = Group::findOrFail($id);
    	$data['items'] = $data['group']->category != NULL ? json_decode($data['group']->category) : [0];
    	$data['category'] = Category::orderBy('title','asc')->get();
    	return view('admin.group.edit')->with('data', $data);
    }
    public function update($id, Request $request)
    {
    	$this->validate($request, [
    		'title' => 'required',
    		'slug' => 'required',
    		'category.*' => 'required',
    		'order' => 'required',
    		'description' => 'sometimes',
    		'image' => 'sometimes',
    	]);
    	$group = Group::findOrFail($id);
    	$file_name = $group->image;
    	if($request->image)
            {
            	if(isset($group->image)){
	                if(File::exists(DIR_IMAGE.$group->image)) {
	                    File::delete(DIR_IMAGE.$group->image);
	                }
	            }
                $file = $request->image;
                $ext = strtolower($file->getClientOriginalExtension()); 
                $file_name = 'group/'.Str::random(10).strtolower($file->GetClientOriginalName());
                $file->move(DIR_IMAGE.'/group/',$file_name);
            }
    	$data = [
    		'title' => $request->title,
    		'slug' => $request->slug,
    		'order' => $request->order,
    		'description' => $request->description,
    		'image' => $file_name,
    		'category' => json_encode($request->category)
    	];
    	$group->update($data);
    	alert()->success('Success', 'Group Updated!');
        return redirect()->route('group.index');
    }
    public function destroy($id)
    {
    	$group = Group::findOrFail($id);
        if(isset($group->image)){
            if(File::exists(DIR_IMAGE.$group->image)) {
                File::delete(DIR_IMAGE.$group->image);
            }
        }
    	$group->delete();
    	alert()->success('Success', 'Group Deleted!');
        return redirect()->route('group.index');
    }
}
