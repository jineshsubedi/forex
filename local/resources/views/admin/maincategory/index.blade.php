@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('sub_category.index')}}">Main Sub Category</a></li>
        <li><span>Index</span></li>
    </ul>
</div>
@endsection
@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection
@section('content')
<style>
    select.form-control:not([size]):not([multiple]) {
        height: calc(2.25rem + 10px);
    }
</style>
<div class="main-content-inner">
    <!-- sales report area start -->
    <div class="sales-report-area mb-5">
        <div class="row">
        	<div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <a href="{{route('main_category.create')}}" class="btn btn-xs btn-primary pull-right"><i class="ti-plus"></i> Add New</a>
                        <h4 class="header-title">Main Sub Categories List</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-control" id="filter_category">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}" @if($data['filter_category'] == $category->id) selected @endif>{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" id="filter_sub_category">
                                    <option value="">Select Sub Category</option>
                                    @foreach($subcategories as $subcategory)
                                    <option value="{{$subcategory->id}}" @if($data['filter_category'] == $subcategory->id) selected @endif>{{$subcategory->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="data-tables">
                            <table id="items_list" class="table table-bordered text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Slug</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($main_categories as $mcategory)
                                    <tr>
                                        <td>{{$mcategory->title}}</td> 
                                        <td>{{\App\Models\Category::getTitle($mcategory->category_id)}}</td>                      
                                        <td>{{\App\Models\SubCategory::getTitle($mcategory->sub_category_id)}}</td>
                                        <td>{{$mcategory->slug}}</td>  
										<td>
											<form method="post" action="{{route('main_category.destroy', $mcategory->id)}}">
												{!! csrf_field() !!}
												{!! method_field('DELETE') !!}
												<!-- <a href="{{route('category.show', $mcategory->id)}}" class="btn btn-xs btn-info"><i class="ti-eye"></i></a> -->
												<a href="{{route('main_category.edit', $mcategory->id)}}" class="btn btn-xs btn-warning"><i class="ti-pencil-alt"></i></a>
												<button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="ti-trash"></i></button>
											</form>
										</td>                                   	
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-right">
                            	{{$main_categories->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div>

@endsection
@section('script')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
<script>
	$('#items_list').DataTable({
		paging: false,
        searching: false
	});

</script>
<script>
    $('#filter_category').change(function(){
        var category = $(this).val();
        var sub_category = $('#filter_sub_category').val();
        var url = '{{url("backend/main_category?")}}';

        if(category != ''){
            url += 'filter_category='+category
        }
        if(sub_category != ''){
            url += 'filter_sub_category='+sub_category
        }

        location = url;
    });
    $('#filter_sub_category').change(function(){
        var sub_category = $(this).val();
        var category = $('#filter_category').val();
        var url = '{{url("backend/main_category?")}}';

        if(category != ''){
            url += 'filter_category='+category
        }
        if(sub_category != ''){
            url += 'filter_sub_category='+sub_category
        }

        location = url;
    });
</script>
@endsection