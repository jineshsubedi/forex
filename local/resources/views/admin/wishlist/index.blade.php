@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('wishlist')}}">Wishlists</a></li>
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
                        <h4 class="header-title">Wishlists List</h4>
                        <div class="data-tables">
                            <table id="vendor_list" class="table table-bordered text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th colspan="4">Product</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wishlists as $wishlist)
                                    <tr>
                                        <td><img src="{{asset('images/'.$wishlist->product_image)}}" style="width:100px;height:100px;object-fit: contain;"></td>                               
                                        <td><a href="{{url('shop/'.$wishlist->product_slug)}}" target="_blank">{{$wishlist->product_title}}</a></td>                               
                                        <td>Rs. {{$wishlist->product_price}} /-</td>                               
										<td>
                                            @if($wishlist->product_price > 0)
                                            <span class="badge badge-success">{{'Available'}}</span>
                                            @else 
                                            <span class="badge badge-danger">{{'Out Of Stock'}}</span>
                                            @endif
                                        </td>                           	
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-right">
                            	{{$wishlists->links()}}
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
	$('#vendor_list').DataTable({
		paging: false,
        "order": []
	});
</script>
@endsection