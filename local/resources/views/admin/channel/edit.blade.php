@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('channel.index')}}">Channel</a></li>
        <li><span>Create</span></li>
    </ul>
</div>
@endsection
@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
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
    select.form-control:not([size]):not([multiple]) {
        height: calc(2.25rem + 8px);
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
                        <h4 class="header-title">Edit A Channel</h4>
                        <p class="text-muted font-14 mb-4">Edit detail to Channel</p>
                        <form method="post" action="{{route('channel.update', $data['channel']->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        
                        <div class="form-group">
                            <label for="example-text-input" class="col-form-label required">Title</label>
                            <input class="form-control" name="title" type="text" value="{{$data['channel']->title}}" id="example-title-input">
                            <div class="text-danger">
                                @if ($errors->has('title'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-start_date-input" class="col-form-label required">Start Date</label>
                            <input class="form-control" name="start_date" type="datetime-local" value="{{date('Y-m-d\TH:i', strtotime($data['channel']->start_date))}}">
                            <div class="text-danger">
                                @if ($errors->has('start_date'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-end_date-input" class="col-form-label required">End Date</label>
                            <input class="form-control" name="end_date" type="datetime-local" value="{{date('Y-m-d\TH:i', strtotime($data['channel']->end_date))}}">
                            <div class="text-danger">
                                @if ($errors->has('end_date'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('end_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-status-input" class="col-form-label required">Status</label>
                            <select class="form-control" name="status">
                                <option value="1" @if($data['channel']->status == 1) selected @endif>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <div class="text-danger">
                                @if ($errors->has('status'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-datetime-local-input" class="col-form-label">Image</label>
                            <input class="form-control" name="image" type="file" id="image">
                            @if($data['channel']->image != NULL)
                                <img src="{{asset('images/'.$data['channel']->image)}}" style="width: 100px;">
                            @endif
                            <div class="text-danger">
                                @if ($errors->has('image'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-datetime-local-input" class="col-form-label">Select Product Related to this channel:</label>
                            <div style="max-height: 400px; overflow-y:scroll; overflow-x: hidden;">
                            <table id="vendor_list" class="table table-bordered text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Check</th>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['product'] as $product)
                                    <tr>
                                        <td>
                                            @if(in_array($product->id, $data['items']))
                                            <input type="checkbox" name="product[]" value="{{$product->id}}" checked>
                                            @else
                                            <input type="checkbox" name="product[]" value="{{$product->id}}">
                                            @endif
                                        </td>
                                        <td><img src="{{asset('images/'.$product->product_attachment->file_name)}}" width="100px;"></td>                                   
                                        <td>{{$product->title}}</td>                                   
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-datetime-local-input" class="col-form-label"></label>
                            <button type="submit" class="btn btn-primary btn-xs mb-3"><i class="ti-harddrive"></i> Update</button>
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
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
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