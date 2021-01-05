@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('category.index')}}">Category</a></li>
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
                        <h4 class="header-title">Edit Category</h4>
                        <p class="text-muted font-14 mb-4">Add detail to Category</p>
                        <form method="post" action="{{route('sub_category.update', $subcategory->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        <div class="form-group">
                            <label class="col-form-label">Category</label>
                            <select class="form-control" id="filter_category" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($subcategory->category_id == $category->id) selected @endif>{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Title</label>
                            <input class="form-control" name="title" type="text" value="{{$subcategory->title}}" id="example-title-input">
                            <div class="text-danger">
                                @if ($errors->has('title'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Slug</label>
                            <input class="form-control" name="slug" type="slug" value="{{$subcategory->slug}}" id="example-slug-input">
                            <div class="text-danger">
                                @if ($errors->has('slug'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('slug') }}</strong>
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
</script>
@endsection