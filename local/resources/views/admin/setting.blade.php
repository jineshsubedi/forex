@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <h4 class="page-title pull-left">Setting</h4>
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('setting')}}">index</a></li>
        <li><span>Setting</span></li>
    </ul>
</div>
@endsection
@section('content')
<div class="main-content-inner">
    <div class="sales-report-area">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Update Setting</h4>
                        <p class="text-muted font-14 mb-4">This setting reflects your site.</p>
                        <form method="post" action="{{route('updateSetting')}}" enctype="multipart/form-data">
                        	@csrf
                        
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Name</label>
                            <input class="form-control" name="app_name" type="text" value="{{$setting->app_name}}" id="example-text-input">
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="col-form-label">Sub Name</label>
                            <input class="form-control" name="sub_name" type="text" value="{{$setting->sub_name}}" id="example-search-input">
                        </div>
                        <div class="form-group">
                            <label for="example-email-input" class="col-form-label">Email</label>
                            <input class="form-control" name="email" type="email" value="{{$setting->email}}" id="example-email-input">
                        </div>
                        <div class="form-group">
                            <label for="example-url-input" class="col-form-label">URL</label>
                            <input class="form-control" name="url" type="url" value="{{isset($setting->url) ? $setting->url : url('/')}}" id="example-url-input">
                        </div>
                        <div class="form-group">
                            <label for="example-tel-input" class="col-form-label">Phone</label>
                            <input class="form-control" name="phone_number1" type="tel" value="{{$setting->phone_number1}}" id="example-tel-input">
                        </div>
                        <div class="form-group">
                            <label for="example-tel-input" class="col-form-label">Phone</label>
                            <input class="form-control" name="phone_number2" type="tel" value="{{$setting->phone_number2}}" id="example-tel-input">
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="col-form-label">Address</label>
                            <input class="form-control" name="address" type="text" value="{{$setting->address}}" id="example-search-input">
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="col-form-label">Map</label>
                            <input class="form-control" name="map" type="text" value="{{$setting->map}}" id="example-search-input">
                            <p style="font-size: 10px;">
                                please use this link to get html code and paste: <a href="https://www.embedgooglemap.net/en/?gclid=EAIaIQobChMIpKW0grDg6wIVmR-tBh3YbgQYEAAYASAAEgI_VvD_BwE" target="_blank">https://www.embedgooglemap.net/en/?gclid=EAIaIQobChMIpKW0grDg6wIVmR-tBh3YbgQYEAAYASAAEgI_VvD_BwE</a><br>
                                make width: 1080px and height 320px;
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="col-form-label">Business Time</label>
                            <textarea class="form-control" name="business_time" rows="3">{!! $setting->business_time !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="example-datetime-local-input" class="col-form-label">Logo</label>
                            <input class="form-control" name="logo" type="file" id="logo">
                            <img src="{{asset('images/'.$setting->logo)}}" alt="asdas" width="100px;">
                        </div>
                        <div class="form-group">
                            <label for="example-datetime-local-input" class="col-form-label">Favicon</label>
                            <input class="form-control" name="favicon" type="file"  id="favicon">
                            <img src="{{asset('images/'.$setting->favicon)}}" alt="asdas" width="100px;">
                        </div>
                        <div class="form-group">
                            <label for="example-datetime-local-input" class="col-form-label">Page Banner</label>
                            <input class="form-control" name="page_banner" type="file"  id="banner">
                            <img src="{{asset('images/'.$setting->page_banner)}}" width="100px;">
                        </div>
                        <div class="form-group">
                        	<label for="example-datetime-local-input" class="col-form-label"></label>
                        	<button type="submit" class="btn btn-primary btn-xs mb-3">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div>
@endsection