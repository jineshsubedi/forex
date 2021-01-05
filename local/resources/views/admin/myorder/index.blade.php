@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('myorder')}}">Order</a></li>
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
<style type="text/css">
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
                        <h4 class="header-title">Order's List</h4>
                        <div class="row">
                        </div>
                        <div class="data-tables">
                            <table id="vendor_list" class="table table-bordered text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Total Amount</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Payment Mode</th>
                                        <th>Status</th>
                                        <th>Order Date</th>
                                        <th>Delivery Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order->total_cost}}</td>
                                        <td>{{$order->phone}}</td>
                                        <td>{{$order->address}}</td>
                                        <td>{{\App\Models\Order::getOrderPaymentMode($order->payment_mode)}}</td>
                                        <td>
                                            <span class="badge badge-primary">{{\App\Models\Order::getOrderStatus($order->status)}}</span>
                                        </td>
                                        <td>{{$order->order_date}}</td>
                                        <td>{{$order->delivery_date}}</td>
										<td>
											<form method="post" action="{{route('order.destroy', $order->id)}}">
												{!! csrf_field() !!}
												{!! method_field('DELETE') !!}
												<a href="{{route('view_myorder', $order->id)}}" class="btn btn-xs btn-info"><i class="ti-eye"></i></a>
											</form>
										</td>                                   	
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-right">
                            	{{$orders->links()}}
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
	});
</script>
@endsection