@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('main_category.index')}}">Main Sub Category</a></li>
        <li><span>Create</span></li>
    </ul>
</div>
@endsection
@section('style')
<style>
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
                        <h4 class="header-title">Edit Main Sub Category</h4>
                        <p class="text-muted font-14 mb-4">Add detail to Main Sub Category</p>
                        <form method="post" action="{{route('main_category.update', $maincategory->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        <div class="form-group">
                            <label class="col-form-label">Category</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($maincategory->category_id == $category->id) selected @endif>{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Sub Category</label>
                            <select class="form-control" id="sub_category_id" name="sub_category_id">
                                <option value="">Select Category</option>
                                @foreach($subcategories as $scategory)
                                <option value="{{$scategory->id}}" @if($maincategory->sub_category_id == $scategory->id) selected @endif>{{$scategory->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Title</label>
                            <input class="form-control" name="title" type="text" value="{{$maincategory->title}}" id="example-title-input">
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
                            <input class="form-control" name="slug" type="slug" value="{{$maincategory->slug}}" id="example-slug-input">
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
    var token = $('input[name=\'_token\']').val();
    $("#example-title-input").blur(function(){
        var data_title = $("#example-title-input").val();
        var data_url = data_title.replace(/ /g,"-");
        $('#example-slug-input').val(data_url);
    })
    $('#category_id').change(function(){
        var category = $(this).val();
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
    })
</script>
@endsection