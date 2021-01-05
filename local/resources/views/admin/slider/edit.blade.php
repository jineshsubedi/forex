@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('slider.index')}}">Slider</a></li>
        <li><span>Create</span></li>
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
    select.form-control:not([size]):not([multiple]) {
        height: calc(2.25rem + 8px);
    }
</style>
@endsection
@section('content')
<div class="main-content-inner">
    <!-- sales report area start -->
    <div class="sales-report-area  mb-5">
        <div class="row">
        	<div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Create Slider</h4>
                        <p class="text-muted font-14 mb-4">Edit detail of Slider</p>
                        <form method="post" action="{{route('slider.update', $slider->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Title</label>
                            <input class="form-control" name="title" type="text" value="{{$slider->title}}" id="example-title-input">
                            <div class="text-danger">
                                @if ($errors->has('title'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Sub Title</label>
                            <input class="form-control" name="sub_title" type="text" value="{{$slider->sub_title}}" id="example-title-input">
                            <div class="text-danger">
                                @if ($errors->has('sub_title'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('sub_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-email-input" class="col-form-label">Url</label>
                            <input class="form-control" name="url" type="url" value="{{$slider->url}}" id="example-url-input">
                            <div class="text-danger">
                                @if ($errors->has('url'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-tel-input" class="col-form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="10">{{$slider->description}}</textarea>
                            <div class="text-danger">
                                @if ($errors->has('description'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-email-input" class="col-form-label">Status</label>
                            <select name="active" id="active" class="form-control">
                                <option value="0" @if($slider->active == 0) selected @endif>Active</option>
                                <option value="1" @if($slider->active == 1) selected @endif>InActive</option>
                            </select>
                            <div class="text-danger">
                                @if ($errors->has('active'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-datetime-local-input" class="col-form-label">Image</label>
                            <input class="form-control" name="image" type="file" id="image">
                            @if($slider->image)
                                <img src="{{asset('images/'.$slider->image)}}" alt="slider image" width="100px;">
                            @endif
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
    	</div>
    </div>
</div>

@endsection
@section('script')
<script src="{{asset('backend/assets/tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/21.0.0/classic/ckeditor.js"></script>
<script>
    $("#example-title-input").blur(function(){
        var data_title = $("#example-title-input").val();
        var data_url = data_title.replace(/ /g,"-");
        $('#example-slug-input').val(data_url);
    })

    ClassicEditor
        .create( document.querySelector( '#description' ) )
        .then( editor => {
                console.log( editor );
        } )
        .catch( error => {
                console.error( error );
        } );
</script>
@endsection