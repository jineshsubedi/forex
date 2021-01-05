@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('order.index')}}">Order</a></li>
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
                        <!-- <a href="{{route('order.create')}}" class="btn btn-xs btn-primary pull-right"><i class="ti-plus"></i> Add New</a> -->
                        <h4 class="header-title">Order's List</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Search Customer:</label>
                                <input type="text" name="filter_customer" id="filter_customer" class="form-control" placeholder="search customer" value="{{$data['filter_customer']}}">
                            </div>
                            <!-- <div class="col-md-3">
                                <label>Payment Mode:</label>
                                <select name="filter_payment_mode" id="filter_payment_mode" class="form-control">
                                    <option value="">Select Mode</option>
                                    @foreach($data['payment_mode'] as $payment)
                                        @if($payment['id'] == $data['filter_payment_mode'])
                                        <option value="{{$payment['id']}}" selected>{{$payment['title']}}</option>
                                        @else
                                        <option value="{{$payment['id']}}">{{$payment['title']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div> -->
                            <div class="col-md-3">
                                <label>Order Status:</label>
                                <select name="filter_status" id="filter_status" class="form-control">
                                    <option value="">Select Status</option>
                                    @foreach($data['status'] as $status)
                                        @if($status['id'] == $data['filter_status'])
                                        <option value="{{$status['id']}}" selected>{{$status['title']}}</option>
                                        @else
                                        <option value="{{$status['id']}}">{{$status['title']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Order Date:</label>
                                <input type="date" name="filter_order_date" id="filter_order_date" class="form-control" placeholder="{{Date('Y-m-d')}}" value="{{$data['filter_order_date']}}">
                            </div>
                            <div class="col-md-3">
                                <label>Shipping Date:</label>
                                <input type="date" name="filter_delivery_date" id="filter_delivery_date" class="form-control" placeholder="{{Date('Y-m-d')}}" value="{{$data['filter_delivery_date']}}">
                            </div>
                        </div>
                        <div class="data-tables">
                            <table id="vendor_list" class="table table-bordered text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Customer</th>
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
                                        <td>{{\App\Models\User::getName($order->customer_id)}}</td>
                                        <td>{{$order->total_cost}}</td>
                                        <td>{{$order->phone}}</td>
										<td>{{$order->address}}</td>
                                        <td>{{\App\Models\Order::getOrderPaymentMode($order->payment_mode)}}</td>
                                        <td>{{\App\Models\Order::getOrderStatus($order->status)}}</td>
                                        <td>{{$order->order_date}}</td>
                                        <td>{{$order->delivery_date}}</td>
										<td>
											<form method="post" action="{{route('order.destroy', $order->id)}}">
												{!! csrf_field() !!}
												{!! method_field('DELETE') !!}
												<a href="{{route('order.show', $order->id)}}" class="btn btn-xs btn-info"><i class="ti-eye"></i></a>
												<!-- <a href="{{route('order.edit', $order->id)}}" class="btn btn-xs btn-warning"><i class="ti-pencil-alt"></i></a> -->
												<button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="ti-trash"></i></button>
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
        searching: false,
	});
    $('#filter_customer').blur(function(){
        filter();
    });
    $('#filter_status').change(function(){
        filter();
    });
    $('#filter_order_date').change(function(){
        filter();
    });
    $('#filter_delivery_date').change(function(){
        filter();
    });
    function filter()
    {
        var customer = $('#filter_customer').val();
        var status = $('#filter_status').val();
        var order_date = $('#filter_order_date').val();
        var delivery_date = $('#filter_delivery_date').val();

        var url = '{{url("backend/order?")}}';
        if(customer != '')
        {
            url += '&filter_customer='+customer;
        }
        if(status != '')
        {
            url += '&filter_status='+status;
        }
        if(order_date != '')
        {
            url += '&filter_order_date='+order_date;
        }
        if(delivery_date != '')
        {
            url += '&filter_delivery_date='+delivery_date;
        }
        
        location = url;
    }
</script>
@endsection