@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('user.index')}}">User</a></li>
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
<div class="main-content-inner">
    <!-- sales report area start -->
    <div class="sales-report-area mb-5">
        <div class="row">
        	<div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <a href="{{route('user.create')}}" class="btn btn-xs btn-primary pull-right"><i class="ti-plus"></i> Add New</a>
                        <h4 class="header-title">User's List</h4>
                        <div class="data-tables">
                            <table id="users_list" class="table table-bordered text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>                                    
                                        <td>{{$user->email}}</td>                                   
										<td>{{$user->phone}}</td>                                 	
										<td>
											@if($user->image)
												<a href="{{asset('images/'.$user->image)}}" target="_blank"><img src="{{asset('images/'.$user->image)}}" alt="" width="100px;"></a>
											@endif
										</td>
										<td>
											<form method="post" action="{{route('user.destroy', $user->id)}}">
												{!! csrf_field() !!}
												{!! method_field('DELETE') !!}
												<a href="{{route('user.show', $user->id)}}" class="btn btn-xs btn-info"><i class="ti-eye"></i></a>
												<a href="{{route('user.edit', $user->id)}}" class="btn btn-xs btn-warning"><i class="ti-pencil-alt"></i></a>
												<button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="ti-trash"></i></button>
											</form>
										</td>                                   	
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-right">
                            	{{$users->links()}}
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
	$('#users_list').DataTable({
		paging: false,
	});
</script>
@endsection