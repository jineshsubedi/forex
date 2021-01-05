<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::where('role', '!=', 'customer')->where('id', '!=', 1)->orderBy('name', 'asc')->paginate(20);
        return view('admin.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
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
            'email' => 'required|unique:users,email',
            'role' => 'required',
            'password' => 'required',
            'phone' => 'sometimes',
            'address' => 'sometimes',
            'image' => 'sometimes|mimes:jpg,png,jpeg|max:2048'
        ]);
        $image = '';
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension()); 
            $image = 'user/'.Str::random(10).strtolower($file->GetClientOriginalName());
            $file->move(DIR_IMAGE.'/user/',$image);
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $image,
        ];
        User::create($data);
        alert()->success('Success', 'User Created!');
        return redirect()->route('user.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
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
            'email' => 'required|unique:users,email,'.$id,
            'role' => 'required',
            'password' => 'sometimes',
            'phone' => 'sometimes',
            'address' => 'sometimes',
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
        alert()->success('Success', 'User Updated!');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if(isset($user->image)){
            if(File::exists(DIR_IMAGE.$user->image)) {
                File::delete(DIR_IMAGE.$user->image);
            }
        }
        $user->delete();
        alert()->success('Success', 'User Deleted Successfully!');
        return redirect()->route('user.index');
    }
}
