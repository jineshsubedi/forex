@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <h4 class="page-title pull-left">Dashboard</h4>
    <ul class="breadcrumbs pull-left">
        <li><a href="index.html">Home</a></li>
        <li><span>Dashboard</span></li>
    </ul>
</div>
@endsection
@section('content')
<!-- page title area start -->

<!-- page title area end -->
<div class="main-content-inner">
    <!-- sales report area start -->
    <div class="sales-report-area mt-5 mb-5">
        <div class="row">
            <div class="col-md-3">
                <div class="single-report mb-xs-30">
                    <div class="s-report-inner pr--20 pt--30 mb-3">
                        <div class="icon"><i class="fa fa-shopping-bag"></i></div>
                        <div class="s-report-title d-flex justify-content-between">
                            <h4 class="header-title mb-0">Product</h4>
                            <!-- <p>24 H</p> -->
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <h2>{{$data['countProduct']}}</h2>
                            <!-- <span>- 45.87</span> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="single-report mb-xs-30">
                    <div class="s-report-inner pr--20 pt--30 mb-3">
                        <div class="icon"><i class="fa fa-users"></i></div>
                        <div class="s-report-title d-flex justify-content-between">
                            <h4 class="header-title mb-0">Customer</h4>
                            <!-- <p>24 H</p> -->
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <h2>{{$data['countCustomer']}}</h2>
                            <!-- <span>- 45.87</span> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="single-report">
                    <div class="s-report-inner pr--20 pt--30 mb-3">
                        <div class="icon"><i class="fa fa-sitemap"></i></div>
                        <div class="s-report-title d-flex justify-content-between">
                            <h4 class="header-title mb-0">Category</h4>
                            <!-- <p>24 H</p> -->
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <h2>{{$data['countCategory']}}</h2>
                            <!-- <span>- 45.87</span> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="single-report">
                    <div class="s-report-inner pr--20 pt--30 mb-3">
                        <div class="icon"><i class="fa fa-cart-arrow-down"></i></div>
                        <div class="s-report-title d-flex justify-content-between">
                            <h4 class="header-title mb-0">Order</h4>
                            <!-- <p>24 H</p> -->
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <h2>{{$data['countOrder']}}</h2>
                            <!-- <span>- 45.87</span> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- sales report area end -->
    <!-- market value area start -->
    <div class="row mt-5 mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <h4 class="header-title mb-0">Orders</h4>
                        <select class="custome-select border-0 pr-3">
                            <option value="">filter</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>
                    <div class="market-status-table mt-4">
                        <div class="table-responsive">
                            <table class="dbkit-table">
                                <thead>
                                <tr class="heading-td">
                                    <td class="mv-icon">Customer</td>
                                    <td class="trends">Total Amount</td>
                                    <td class="attachments">Payment Mode</td>
                                    <td class="stats-chart">Status</td>
                                    <td class="stats-chart">Order Date</td>
                                    <td class="stats-chart">Date</td>
                                    <td class="stats-chart">action</td>
                                </tr></thead>
                                <tbody>
                                    @if(count($data['orders']) > 0)
                                    @foreach($data['orders'] as $order)
                                    <tr>
                                        <td class="mv-icon">{{\App\Models\User::getName($order->customer_id)}}</td>
                                        <td class="trends">{{$order->total_cost}}</td>
                                        <td>{{\App\Models\Order::getOrderPaymentMode($order->payment_mode)}}</td>
                                        <td class="attachments">{{\App\Models\Order::getOrderStatus($order->status)}}</td>
                                        <td class="stats-chart">{{$order->order_date}}</td>
                                        <td class="stats-chart">{{$order->delivery_date}}</td>
                                        <td class="stats-chart">action</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="7">
                                            <p class="text-center">No Order Found!</p>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- market value area end -->
</div>
@endsection