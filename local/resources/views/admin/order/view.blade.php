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
                        <h4 class="header-title">Order's Detail</h4>
                        <form method="post" action="{{route('order.update', $datas['order']->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4">
                                    <h4><u>General Detail</u></h4>
                                    <div class="form-group mt-3">
                                        <label>Order Date</label>
                                        <input type="text" name="order_date" value="{{$datas['order']->order_date}}" class="form-control" disabled>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Order Status</label>
                                        <select name="order_status" class="form-control" @if($datas['order']->status=='order_complete') disabled @endif>
                                            @foreach($datas['status'] as $status)
                                                @if($status['id'] == $datas['order']->status)
                                                <option value="{{$status['id']}}" selected >{{$status['title']}}</option>
                                                @else 
                                                <option value="{{$status['id']}}">{{$status['title']}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div></div>
                                </div>
                                <div class="col-md-4">
                                    <h4><u>Billing Detail</u></h4>
                                    <div class="form-group mt-3">
                                        <label>Address</label>
                                        <div>
                                            <p>First Name: {{$datas['customer_address']->first_name}}</p>
                                            <p>Last Name: {{$datas['customer_address']->last_name}}</p>
                                            <p>Email: {{$datas['customer_address']->email}}</p>
                                            <p>Phone: {{$datas['customer_address']->phone_number}}</p>
                                            <p>Street: {{$datas['customer_address']->street}}</p>
                                            <p>City: {{$datas['customer_address']->city}}</p>
                                            <p>State: {{$datas['customer_address']->state}}</p>
                                            <p>Country: {{$datas['customer_address']->country}}</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <h4><u>Shipping Detail</u></h4>
                                    <div class="form-group mt-3">
                                        <label>Shipping Type:</label>
                                        <input type="text" name="shipping_type" value="Free" disabled class="form-control">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Shipping Date:</label>
                                        @if($datas['order']->status=='order_complete')
                                            <input type="date" name="shipping_date" value="{{$datas['order']->delivery_date}}" class="form-control" disabled>
                                        @else
                                            <input type="date" name="shipping_date" value="{{$datas['order']->delivery_date}}" class="form-control">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                <hr>
                                    @if($datas['order']->status=='order_complete') 
                                        <span>Order Completed!</span>
                                    @else
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Order's Items</h4>
                        <table id="vendor_list" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Unit Cost</th>
                                    <th>Quantity</th>
                                    <th>Total Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas['order_item'] as $item)
                                <tr>
                                    <td>
                                        <img src="{{asset('images/'.$item->product_image)}}" width="100px">
                                    </td>
                                    <td>{{$item->product_name}}</td>
                                    <td>Rs. {{$item->unit_cost}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>Rs. {{$item->total_cost}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-right">Total Cost</td>
                                    <td>Rs. {{$datas['order']->total_cost}}</td>
                                </tr>
                            </tbody>
                        </table>
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