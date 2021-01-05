@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('order.index')}}">Order</a></li>
        <li><span>Create</span></li>
    </ul>
</div>
@endsection
@section('style')
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
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
                        <h4 class="header-title">Create Order</h4>
                        <p class="text-muted font-14 mb-4">Add Customer Order</p>
                        <form method="post" action="{{route('order.store')}}" enctype="multipart/form-data">
                            @csrf
                        
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label">Customer</label>
                            <input class="form-control" name="customer" id="customer_name" type="text" value="{{old('customer')}}" id="example-customer-input">
                            <input class="form-control" name="customer_id" id="customer_id" type="hidden" value="{{old('customer_id')}}">
                            <div class="text-danger">
                                @if ($errors->has('customer'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('customer') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-product-input" class="col-form-label">Product</label>
                            <select class="form-control" name="product_id" id="product_id">
                                <option value="">Select Product</option>
                                @foreach($data['product'] as $product)
                                    @if($product->id == old('product_id'))
                                    <option value="{{$product->id}}" selected>{{\App\Models\Item::getTitle($product->item_id)}}</option>
                                    @else
                                    <option value="{{$product->id}}">{{\App\Models\Item::getTitle($product->item_id)}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="text-danger">
                                @if ($errors->has('product_id'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('product_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-product-input" class="col-form-label">Uni Cost</label>
                            <input type="text" name="unit_cost" id="unit_cost" value="{{old('unit_cost')}}" class="form-control" disabled>
                        </div>
                        
                        <div class="form-group">
                            <label for="example-tags-input" class="col-form-label">Quantity</label>
                            <input class="form-control" type="number" name="quantity" value="{{old('quantity')}}" id="quantity">
                            <div class="text-danger">
                                @if ($errors->has('quantity'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-payment-input" class="col-form-label">Payment Mode</label>
                            <select class="form-control" name="payment_id" id="example-payment-input">
                                <option value="">Select Mode</option>
                                @foreach($data['payment_mode'] as $payment)
                                    @if($payment['id'] == old('payment_id'))
                                    <option value="{{$payment['id']}}" selected>{{$payment['title']}}</option>
                                    @else
                                    <option value="{{$payment['id']}}">{{$payment['title']}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="text-danger">
                                @if ($errors->has('payment_id'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('payment_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-datetime-local-input" class="col-form-label">Order Date</label>
                            <input class="form-control" name="order_date" type="date" id="order_date" value="{{old('order_date')}}">
                            <div class="text-danger">
                                @if ($errors->has('order_date'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('order_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-datetime-local-input" class="col-form-label">Delivery Date</label>
                            <input class="form-control" name="delivery_date" type="date" id="delivery_date" value="{{old('delivery_date')}}">
                            <div class="text-danger">
                                @if ($errors->has('delivery_date'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('delivery_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label for="example-total_amount-input" class="col-form-label">Total Amount</label>
                            <input class="form-control" type="number" name="total_amount" value="{{old('total_amount')}}" id="total_amount">
                            <div class="text-danger">
                                @if ($errors->has('total_amount'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('total_amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-status-input" class="col-form-label">Order Status</label>
                            <select class="form-control" name="status_id" id="example-status-input">
                                <option value="">Select Status</option>
                                @foreach($data['status'] as $status)
                                    @if($status['id'] == old('status_id'))
                                    <option value="{{$status['id']}}" selected>{{$status['title']}}</option>
                                    @else
                                    <option value="{{$status['id']}}">{{$status['title']}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="text-danger">
                                @if ($errors->has('status_id'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('status_id') }}</strong>
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $('#customer_name').autocomplete({
        source: '{{url("order/customer/autocomplete")}}',
        autoFocus:true,
        minLength: 1,
        select: function(event, ui) {
          var value = ui.item.value
          $('#customer_id').val(ui.item.id);
        }
    });
    var token = $('input[name=\'_token\']').val();
    $('#product_id').change(function(){
        var productId = $(this).val();
        $.ajax({
            url: "{{route('admin.getItemByProduct')}}",
            data:{
                _token: token,
                product_id: productId,
            },
            type: 'post',
            dataType: 'JSON',
            cache: false,
            success:function(data){
              // console.log(data)
              $('#unit_cost').val(data.price)
            },
            error: function(error){
              alert('error');
            } 
        });
    })
    $('#quantity').change(function(){
        var unit = parseFloat($('#unit_cost').val());
        var quantity = parseInt($('#quantity').val());
        var total = unit * quantity;
        console.log(unit)
        console.log(quantity)
        console.log(total)
        $('#total_amount').val(total);
    })
    $('#unit_cost').change(function(){
        var unit = parseFloat($('#unit_cost').val());
        var quantity = parseInt($('#quantity').val());
        var total = unit * quantity;
        console.log(unit)
        console.log(quantity)
        console.log(total)
        $('#total_amount').val(total);
    })
</script>
@endsection