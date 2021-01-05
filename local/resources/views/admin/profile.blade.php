@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <h4 class="page-title pull-left">Profile</h4>
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('home')}}">Dashboard</a></li>
        <li><span>Profile</span></li>
    </ul>
</div>
@endsection
@section('style')
<link rel="stylesheet" href="{{asset('backend/assets/tagsinput/dist/bootstrap-tagsinput.css')}}">
<style>
    .bootstrap-tagsinput .tag {
        margin-right: 2px;
        color: white;
        background-color: #c79b39;
        padding: 3px;
        border-radius: 3px;
    }
    .bootstrap-tagsinput {
        width:100%;
    }
</style>
@endsection
@section('content')


<div class="main-content-inner">
    <!-- sales report area start -->
    <div class="sales-report-area  mb-5">
        <div class="row">
        	<div class="col-md-4 mt-5">
        		<div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Profile View</h4>
                        <div class="form-group">
                        	@if($user->image)
                        	<img src="{{asset('images/'.$user->image)}}" alt="" class="img-circle" style="object-fit: contain; width: 150px; height:150px;background-color: #dee2e6; border: 1px solid #ffc107; border-radius: 50%;">
                        	@else
                        	<img src="{{asset('backend/assets/images/author/author-img1.jpg')}}" alt="" class="img-circle" style="object-fit: contain; width: 150px; height:150px;background-color: #dee2e6; border: 1px solid #ffc107; border-radius: 50%;">
                        	@endif
                        	<h3>{{$user->name}}</h3>
                        	<p>{{$user->email}}</p>
                        	<p>{{$user->address}}</p>
                        	<p>
                        		@php($phones = explode(',',$user->phone))
                        		@foreach($phones as $phone)
                        		<span class="badge badge-warning">{{$phone}}</span>
                        		@endforeach
                        	</p>
                        </div>
                    </div>
                </div>
            </div>
            @if($user->role == 'super admin' || $user->id == Auth::user()->id)
        	<div class="col-md-8 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Update Profile</h4>
                        <p class="text-muted font-14 mb-4">Update profile</p>
                        <form method="post" action="{{route('profile.update', $user->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Name</label>
                            <input class="form-control" name="name" type="text" value="{{$user->name}}" id="example-name-input">
                            <div class="text-danger">
                                @if ($errors->has('name'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Email</label>
                            <input class="form-control" name="email" type="text" value="{{$user->email}}" id="example-email-input">
                            <div class="text-danger">
                                @if ($errors->has('email'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Password</label>
                            <input class="form-control" name="password" type="password" value="{{old('password')}}" id="example-password-input">
                            <div class="text-danger">
                                @if ($errors->has('password'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">	
                            <label for="example-phone-input" class="col-form-label">Phone</label>
                            <input class="form-control" data-role="tagsinput" name="phone" type="text" value="{{$user->phone}}" id="example-phone-input">
                            <div class="text-danger">
                                @if ($errors->has('phone'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Address</label>
                            <input class="form-control" name="address" type="text" value="{{$user->address}}" id="example-address-input">
                            <div class="text-danger">
                                @if ($errors->has('address'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-datetime-local-input" class="col-form-label">Image</label>
                            <input class="form-control" name="image" type="file" id="image">
                            <div class="text-danger">
                                @if ($errors->has('image'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-datetime-local-input" class="col-form-label"></label>
                            <button type="submit" class="btn btn-primary btn-xs mb-3"><i class="ti-harddrive"></i> Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
    	</div>
    </div>
</div>


@endsection
@section('script')
<script src="{{asset('backend/assets/tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
@endsection