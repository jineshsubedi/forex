<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = User::where('role', 'customer')->orderBy('name', 'asc')->paginate(20);
        return view('admin.customer.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customer.create');
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
        alert()->success('Success', 'Customer Created!');
        return redirect()->route('customer.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = customer::findOrFail($id);
        return view('admin.customer.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customer.edit', compact('customer'));
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
        alert()->success('Success', 'Customer Updated!');
        return redirect()->route('customer.index');
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
        alert()->success('Success', 'Customer Deleted Successfully!');
        return redirect()->route('customer.index');
    }
}
