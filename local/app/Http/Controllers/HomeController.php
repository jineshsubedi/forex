<?php

namespace App\Http\Controllers;

use Auth;
use File;
use SweetAlert;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['countProduct'] = Product::count();
        $data['countCustomer'] = User::where('role', 'customer')->count();
        $data['countCategory'] = Category::count();
        $data['countOrder'] = Order::count();

        $data['orders'] = Order::get();
        
        return view('admin/dashboard')->with('data', $data);
    }
    public function setting()
    {
        $setting = \App\Models\Setting::find(1);
        return view('admin.setting', compact('setting'));
    }
    public function updateSetting(Request $request)
    {
        $this->validate($request, [
            'app_name' =>'required',
            'sub_name' =>'sometimes',
            'url' =>'required',
            'email' =>'required',
            'address' =>'required',
            'map' =>'required',
            'phone_number1' =>'required',
            'phone_number2' =>'sometimes',
            'business_time' =>'sometimes',
        ]);

        $setting = \App\Models\Setting::find(1);

        $logo = $setting->logo;
        $favicon = $setting->favicon;
        $page_banner = $setting->page_banner;

        if($request->hasfile('logo'))
        {
            $this->validate($request, [
                'logo' =>'required|mimes:jpg,png,jpeg,gif|max:2048',
            ]);
            $file = $request->file('logo');
            $ext = strtolower($file->getClientOriginalExtension()); 
            $logo = 'main/'.'logo-'.strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/main/',$logo);
            if(isset($setting->logo)){
                if(File::exists(DIR_IMAGE.$setting->logo)) {
                    File::delete(DIR_IMAGE.$setting->logo);
                }
            }
        }
        if($request->hasfile('favicon'))
        {
            $this->validate($request, [
                'favicon' =>'required|mimes:jpg,png,jpeg,gif|max:2048',
            ]);
            
            $file = $request->file('favicon');
            $ext = strtolower($file->getClientOriginalExtension()); 
            $favicon = 'main/'.'favicon-'.strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/main/',$favicon);
            if(isset($setting->favicon)){
                if(File::exists(DIR_IMAGE.$setting->favicon)) {
                    File::delete(DIR_IMAGE.$setting->favicon);
                }
            }

        }
        if($request->hasfile('page_banner'))
        {
            $this->validate($request, [
                'page_banner' =>'required|mimes:jpg,png,jpeg,gif|max:2048',
            ]);
            
            $file = $request->file('page_banner');
            $ext = strtolower($file->getClientOriginalExtension()); 
            $page_banner = 'main/'.'page_banner-'.strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/main/',$page_banner);
            if(isset($setting->page_banner)){
                if(File::exists(DIR_IMAGE.$setting->page_banner)) {
                    File::delete(DIR_IMAGE.$setting->page_banner);
                }
            }

        }

        $data = [
            'app_name' => $request->app_name,
            'sub_name' => $request->sub_name,
            'url' => $request->url,
            'email' => $request->email,
            'address' => $request->address,
            'map' => $request->map,
            'phone_number1' => $request->phone_number1,
            'phone_number2' => $request->phone_number2,
            'business_time' => nl2br($request->business_time),
            'logo' => $logo,
            'favicon' => $favicon,
            'page_banner' => $page_banner,
        ];

        \App\Models\Setting::find(1)->update($data);
        alert()->success('Success', 'Settings updated!');
        return redirect()->back();
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);
        if($user->role == 'customer')
        {
            if($user->id != Auth::user()->id){
                alert()->info('Warning', 'You are not authorized!');
                return redirect()->route('home');
            }
        }
        return view('admin.profile', compact('user'));
    }
    public function profileUpdate($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'password' => 'sometimes',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'sometimes|mimes:jpg,png,jpeg|max:2048'
        ]);
        $user = User::findOrFail($id);
        $image = $user->image;
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension()); 
            $image = 'user/'.Str::random(10).strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/user/',$image);

            if(isset($user->image)){
                if(File::exists(DIR_IMAGE.$user->image)) {
                    File::delete(DIR_IMAGE.$user->image);
                }
            }
        }
        if($request->password){
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $image,
            ];
        }else{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $image,
            ];
        }
            
        User::find($id)->update($data);
        alert()->success('Success', 'Profile Updated!');
        return redirect()->route('profile', $id);
    }

    public function message(Request $request)
    {
        $messages = \App\Models\Contact::orderBy('id', 'desc')->paginate(50);
        return view('admin.message.index', compact('messages'));
    }
}
