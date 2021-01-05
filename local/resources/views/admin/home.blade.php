@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <h4 class="page-title pull-left">Dashboard</h4>
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('home')}}">Home</a></li>
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
            <div class="col-md-4">
                <div class="single-report mb-xs-30">
                    <div class="s-report-inner pr--20 pt--30 mb-3">
                        <div class="icon"><i class="fa fa-btc"></i></div>
                        <div class="s-report-title d-flex justify-content-between">
                            <h4 class="header-title mb-0">Bitcoin</h4>
                            <p>24 H</p>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <h2>$ 4567809,987</h2>
                            <span>- 45.87</span>
                        </div>
                    </div>
                    <canvas id="coin_sales1" height="100"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="single-report mb-xs-30">
                    <div class="s-report-inner pr--20 pt--30 mb-3">
                        <div class="icon"><i class="fa fa-btc"></i></div>
                        <div class="s-report-title d-flex justify-content-between">
                            <h4 class="header-title mb-0">Bitcoin Dash</h4>
                            <p>24 H</p>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <h2>$ 4567809,987</h2>
                            <span>- 45.87</span>
                        </div>
                    </div>
                    <canvas id="coin_sales2" height="100"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="single-report">
                    <div class="s-report-inner pr--20 pt--30 mb-3">
                        <div class="icon"><i class="fa fa-eur"></i></div>
                        <div class="s-report-title d-flex justify-content-between">
                            <h4 class="header-title mb-0">Euthorium</h4>
                            <p>24 H</p>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <h2>$ 4567809,987</h2>
                            <span>- 45.87</span>
                        </div>
                    </div>
                    <canvas id="coin_sales3" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- sales report area end -->
</div>
@endsection