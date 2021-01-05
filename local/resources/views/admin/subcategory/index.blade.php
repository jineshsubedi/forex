@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('sub_category.index')}}">Sub Category</a></li>
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
        height: calc(2.25rem + 5px);
    }
</style>
<div class="main-content-inner">
    <!-- sales report area start -->
    <div class="sales-report-area mb-5">
        <div class="row">
        	<div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <a href="{{route('sub_category.create')}}" class="btn btn-xs btn-primary pull-right"><i class="ti-plus"></i> Add New</a>
                        <h4 class="header-title">Sub Categories List</h4>
                        <div class="col-md-4">
                            <select class="form-control" id="filter_category">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($data['filter_category'] == $category->id) selected @endif>{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="data-tables">
                            <table id="items_list" class="table table-bordered text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Slug</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sub_categories as $category)
                                    <tr>
                                        <td>{{$category->title}}</td> 
                                        <td>{{\App\Models\Category::getTitle($category->category_id)}}</td>                                   
                                        <td>{{$category->slug}}</td>  
										<td>
											<form method="post" action="{{route('sub_category.destroy', $category->id)}}">
												{!! csrf_field() !!}
												{!! method_field('DELETE') !!}
												<!-- <a href="{{route('category.show', $category->id)}}" class="btn btn-xs btn-info"><i class="ti-eye"></i></a> -->
												<a href="{{route('sub_category.edit', $category->id)}}" class="btn btn-xs btn-warning"><i class="ti-pencil-alt"></i></a>
												<button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="ti-trash"></i></button>
											</form>
										</td>                                   	
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-right">
                            	{{$sub_categories->links()}}
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
        var url = '{{url("backend/sub_category?")}}';

        if(category != ''){
            url += 'filter_category='+category
        }

        location = url;
    });
</script>
@endsection