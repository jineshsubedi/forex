@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('group.index')}}">Group</a></li>
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
                        <h4 class="header-title">Create A Group</h4>
                        <p class="text-muted font-14 mb-4">Add detail to Group</p>
                        <form method="post" action="{{route('group.store')}}" enctype="multipart/form-data">
                            @csrf
                        
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label required">Title</label>
                            <input class="form-control" name="title" type="text" value="{{old('title')}}" id="example-title-input">
                            <div class="text-danger">
                                @if ($errors->has('title'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-slug-input" class="col-form-label required">Slug</label>
                            <input class="form-control" name="slug" type="text" value="{{old('slug')}}" id="example-slug-input">
                            <div class="text-danger">
                                @if ($errors->has('slug'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-order-input" class="col-form-label required">Order</label>
                            <input class="form-control" name="order" type="text" value="{{old('order')}}" id="example-order-input">
                            <div class="text-danger">
                                @if ($errors->has('order'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-tel-input" class="col-form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="10" max="200">{{old('description')}}</textarea>
                            <div class="text-danger">
                                @if ($errors->has('description'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
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
                            <label for="example-datetime-local-input" class="col-form-label required">Choose Preferred Categories</label> <br>
                            @foreach($data['category'] as $category)
                            <input name="category[]" type="checkbox" value="{{$category->id}}"> {{$category->title}}
                            @endforeach
                            <div class="text-danger">
                                @if ($errors->has('categories'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('categories') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="example-datetime-local-input" class="col-form-label"></label>
                            <button type="submit" class="btn btn-primary btn-xs mb-3"><i class="ti-harddrive"></i> Save</button>
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