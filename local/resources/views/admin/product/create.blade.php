@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('product.index')}}">Product</a></li>
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
        height: calc(2.25rem + 10px);
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
                        <h4 class="header-title">Create Product</h4>
                        <p class="text-muted font-14 mb-4">Add detail to Product</p>
                        <form method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Title</label>
                                <input class="form-control" name="title" type="text" value="{{old('title')}}" id="example-title-input">
                                <div class="text-danger">
                                    @if ($errors->has('title'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="example-text-input" class="col-form-label">Slug</label>
                                <input class="form-control" name="slug" type="slug" value="{{old('slug')}}" id="example-slug-input">
                                <div class="text-danger">
                                    @if ($errors->has('slug'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('slug') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-form-label required">Category</label>
                            <select name="category_id" class="form-control" id="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                @if($category->id == old('category_id'))
                                <option value="{{$category->id}}" selected>{{$category->title}}</option>
                                @else
                                <option value="{{$category->id}}">{{$category->title}}</option>
                                @endif
                                @endforeach
                            </select>
                            <div class="text-danger">
                                @if ($errors->has('category_id'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label required">Sub Category</label>
                            <select name="sub_category_id" class="form-control" id="sub_category_id">
                                <option value="0">Select Category</option>
                            </select>
                            <div class="text-danger">
                                @if ($errors->has('sub_category_id'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('sub_category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label required">Main Sub Category</label>
                            <select name="main_category_id" class="form-control" id="main_category_id">
                                <option value="0">Select Sub Category</option>
                            </select>
                            <div class="text-danger">
                                @if ($errors->has('main_category_id'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('main_category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label required">Featured</label>
                            <select name="featured" class="form-control" id="featured">
                                <option value="0">Not Featured</option>
                                <option value="1">Featured</option>
                            </select>
                            <div class="text-danger">
                                @if ($errors->has('featured'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('featured') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label required">New</label>
                            <select name="new" class="form-control" id="new">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            <div class="text-danger">
                                @if ($errors->has('new'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('new') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label required">Price</label>
                            <input type="text" name="price" class="form-control" placeholder="Product price" value="{{old('price')}}">
                            <div class="text-danger">
                                @if ($errors->has('price'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label required">Brand</label>
                            <input type="text" name="brand" class="form-control" placeholder="Product brand" value="{{old('brand')}}">
                            <div class="text-danger">
                                @if ($errors->has('brand'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('brand') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label required">Inventory</label>
                            <input type="text" name="inventory" class="form-control" placeholder="Product inventory" value="{{old('inventory')}}">
                            <div class="text-danger">
                                @if ($errors->has('inventory'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('inventory') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label required">Description</label>
                            <textarea class="form-control" id="description" rows="10" name="description" placeholder="product description">{{old('description')}}</textarea>
                            <div class="text-danger">
                                @if ($errors->has('description'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div id="mainMultiFormSection" style="border:1px solid #dfdede; padding: 10px; margin-bottom: 10px; border-radius: 10px;">
                            @if(old('image'))
                            @for($i=0; $i < count(old('image')); $i++)
                            <div id="oldForm{{$i}}" class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Image</label>
                                        <input class="form-control" name="image[]" id="image{{$i}}" type="file" value="{{old('image.'.$i)}}">
                                        <div class="text-danger">
                                            @if ($errors->has('image.'.$i))
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $errors->first('image.'.$i) }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-xs btn-danger" type="button" style="margin-top: 40px;" onclick="removeOldForm({{$i}})"><i class="ti-trash"></i></button>
                                </div>
                            </div>
                            @endfor
                            @else
                            <div id="newForm1" class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Image</label>
                                        <input class="form-control" name="image[]" id="image1" type="file" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-xs btn-danger" type="button" style="margin-top: 40px;" onclick="removeForm(1)"><i class="ti-trash"></i></button>
                                </div>
                            </div>
                            @endif
                        </div>
                                        
                        <div class="form-group">
                            <label for="example-datetime-local-input" class="col-form-label"></label>
                            <button type="submit" class="btn btn-primary btn-xs"><i class="ti-harddrive"></i> Save</button>
                            <button type="button" class="btn btn-warning btn-xs" onclick="addMoreForm()"><i class="ti-harddrive"></i> Add More Product Image</button>
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
<script src="{{asset('theme/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('backend/assets/tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/21.0.0/classic/ckeditor.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#description' ) )
        .then( editor => {
                console.log( editor );
        } )
        .catch( error => {
                console.error( error );
        } );

    function shuffleSlug(id)
    {
        var data_title = $("#title"+id).val();
        var data_url = data_title.replace(/ /g,"-");
        $('#slug'+id).val(data_url);
    }

    function removeForm(id)
    {
        $('#newForm'+id).remove();
    }

    var count = 1;
    function addMoreForm()
    {
        count++;
        var formHtml = '<div id="newForm'+count+'" class="row"><div class="col-md-10"><div class="form-group"><label for="example-text-input" class="col-form-label">Image</label><input class="form-control" name="image[]" id="image'+count+'" type="file" ></div></div><div class="col-md-2"><button class="btn btn-xs btn-danger" type="button" style="margin-top: 40px;" onclick="removeForm('+count+')"><i class="ti-trash"></i></button></div></div>';

        $('#mainMultiFormSection').append(formHtml);
    }

    function removeOldForm(id)
    {
        $('#oldForm'+id).remove();
    }
    $("#example-title-input").blur(function(){
        var data_title = $("#example-title-input").val();
        var data_url = data_title.replace(/ /g,"-");
        $('#example-slug-input').val(data_url);
    })
    function addItem()
    {
        $('#item_id').val(0);
        $('#addnewitem').toggle();
    }
</script>
<script>
    var token = $('input[name=\'_token\']').val();
    $('#category_id').change(function(){
        var category = $(this).val();
        ajaxSubCategoryCall(category)
    });
    var category = $('#category_id').val();
    if(category != ''){
        ajaxSubCategoryCall(category)
    }
    $('#sub_category_id').change(function(){
        var category = $(this).val();
        ajaxMainCategoryCall(category)
    });
    var sub_category = $('#sub_category_id').val();
    if(sub_category != ''){
        ajaxMainCategoryCall(sub_category)
    }
    function ajaxSubCategoryCall(category)
    {
        $.ajax({
            url: "{{route('getSubCategoryByCategoryId')}}",
            type: 'post',
            data:{
                _token : token,
                category_id : category
            },
            dataType: 'JSON',
            success:function(data){
                var old_category_id = '{{old("sub_category_id")}}';
                var optionHtml = '<option value="0">Select Sub Category</option>'
                $.each(data, function(index, value){
                    if(old_category_id == value.id){
                        optionHtml += '<option value="'+value.id+'" selected>'+value.title+'</option>'
                    }else{
                        optionHtml += '<option value="'+value.id+'">'+value.title+'</option>'
                    }
                })
                $('#sub_category_id').html(optionHtml)
            },
            error: function(error){
                swal({
                  title: "Failed!",
                  text: "Sub category failed to load",
                  icon: "error",
                  button: "OK",
                });
            }
        });
    }
    function ajaxMainCategoryCall(sub_category)
    {
        $.ajax({
            url: "{{route('getMainCategoryBySubCategoryId')}}",
            type: 'post',
            data:{
                _token : token,
                category_id : sub_category
            },
            dataType: 'JSON',
            success:function(data){
                var old_main_category_id = '{{old("main_category_id")}}';
                var optionHtml = '<option value="0">Select Main Sub Category</option>'
                $.each(data, function(index, value){
                    if(old_main_category_id == value.id){
                        optionHtml += '<option value="'+value.id+'" selected>'+value.title+'</option>'
                    }else{
                        optionHtml += '<option value="'+value.id+'">'+value.title+'</option>'
                    }
                })
                $('#main_category_id').html(optionHtml) 
            },
            error: function(error){
            }
        });
    }
</script>
@endsection