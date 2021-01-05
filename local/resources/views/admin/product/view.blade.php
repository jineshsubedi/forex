@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('product.index')}}">Product Detail</a></li>
        <li><span>Index</span></li>
    </ul>
</div>
@endsection
@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection
@section('content')
<div class="main-content-inner">
    <!-- sales report area start -->
    <div class="sales-report-area mb-5">
        <div class="row">
        	<div class="col-sm-5">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    @foreach($attachments as $k=>$attachment)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{$k}}" @if($k==0) class="active" @endif></li>
                    @endforeach
                  </ol>
                  <div class="carousel-inner">
                    @foreach($attachments as $k=>$attachment)
                    <div class="carousel-item @if($k==0) active @endif">
                      <img class="d-block w-100" src="{{asset('images/'.$attachment->file_name)}}" alt="First slide">
                    </div>
                    @endforeach
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="product-information"><!--/product-information-->
                                <img src="images/product-details/new.jpg" class="newarrival" alt="">
                                <h2>{{$product->title}}</h2>
                                <p>Rs. {{$product->price}}</p>
                                <p>{{\App\Models\Category::getTitle($product->category_id)}} >> {{\App\Models\SubCategory::getTitle($product->sub_category_id)}}</p>
                                <p>{!! $product->description !!}</p>
                            </div>
            </div>
    	</div>
    </div>
</div>

@endsection
@section('script')
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
@endsection