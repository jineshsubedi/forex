<?php

namespace App\Http\Controllers\Admin;

use Auth;
use File;
use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sliders = Slider::orderBy('id', 'desc')->paginate(20);
        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
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
            'sub_title' => 'sometimes',
            'url' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        
        $image = '';
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension()); 
            $image = 'slider/'.Str::random(10).strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/slider/',$image);
        }

        $data = [
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'url' => $request->url,
            'description' => $request->description,
            'image' => $image,
        ];
        $slider = Slider::create($data);
        alert()->success('Success', 'Slider Created!');
        return redirect()->route('slider.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idate(format)
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.view', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
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
            'sub_title' => 'sometimes',
            'url' => 'required',
            'description' => 'required',
            'active' => 'required',
            'image' => 'sometimes|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        $slider = Slider::findOrFail($id);
        $image = $slider->image;
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension()); 
            $image = 'slider/'.Str::random(10).strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/slider/',$image);

            if(isset($slider->image)){
                if(File::exists(DIR_IMAGE.$slider->image)) {
                    File::delete(DIR_IMAGE.$slider->image);
                }
            }
        }
        $data = [
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'url' => $request->url,
            'description' => $request->description,
            'active' => $request->active,
            'image' => $image,
        ];
        Slider::find($id)->update($data);
        alert()->success('Success', 'Slider Updated!');
        return redirect()->route('slider.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        if(isset($slider->image)){
            if(File::exists(DIR_IMAGE.$slider->image)) {
                File::delete(DIR_IMAGE.$slider->image);
            }
        }
        $slider->delete();
        alert()->success('Success', 'Slider Deleted Successfully!');
        return redirect()->route('slider.index');
    }
}
