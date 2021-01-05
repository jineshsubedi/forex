<?php

namespace App\Http\Controllers\Admin;

use Auth;
use File;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pages = Page::orderBy('id', 'desc')->paginate(20);
        return view('admin.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page.create');
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
            'slug' => 'sometimes',
            'description' => 'required',
            'banner' => 'sometimes|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        
        $banner = '';
        if($request->hasfile('banner'))
        {
            $file = $request->file('banner');
            $ext = strtolower($file->getClientOriginalExtension()); 
            $banner = 'page/'.Str::random(10).strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/page/',$banner);
        }

        $data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'banner' => $banner,
        ];
        $page = Page::create($data);
        alert()->success('Success', 'Page Created!');
        return redirect()->route('page.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idate(format)
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.page.view', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.page.edit', compact('page'));
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
            'status' => 'required',
            'banner' => 'sometimes|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        $page = Page::findOrFail($id);
        $banner = $page->banner;
        if($request->hasfile('banner'))
        {
            $file = $request->file('banner');
            $ext = strtolower($file->getClientOriginalExtension()); 
            $banner = 'page/'.Str::random(10).strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/page/',$banner);

            if(isset($page->banner)){
                if(File::exists(DIR_IMAGE.$page->banner)) {
                    File::delete(DIR_IMAGE.$page->banner);
                }
            }
        }
        $data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'status' => $request->status,
            'banner' => $banner,
        ];
        Page::find($id)->update($data);
        alert()->success('Success', 'Page Updated!');
        return redirect()->route('page.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        if(isset($page->banner)){
            if(File::exists(DIR_IMAGE.$page->banner)) {
                File::delete(DIR_IMAGE.$page->banner);
            }
        }
        $page->delete();
        alert()->success('Success', 'page Deleted Successfully!');
        return redirect()->route('page.index');
    }
}
