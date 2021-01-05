@extends('layouts.backend.app')
@section('breadcrums')
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        <li><a href="{{route('message.index')}}">Message</a></li>
        <li><span>Index</span></li>
    </ul>
</div>
@endsection
@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
<style>
    .unseen {background-color: #e5e5e5 !important;}
</style>
@endsection
@section('content')
<div class="main-content-inner">
    <!-- sales report area start -->
    <div class="sales-report-area mb-5">
        <div class="row">
        	<div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Messages List</h4>
                        <div class="data-tables">
                            <table id="vendor_list" class="table table-bordered text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                    <tr class="unseen">
										<td>{{$message->name}}</td>                                    	
                                        <td>{{$message->email}}</td>                                    
                                        <td>{{$message->phone}}</td>                                    
                                        <td>{{$message->subject}}</td>                                    
                                        <td>{!! str_limit($message->message, 100) !!}</td>                                      
										<td>
                                            <button type="button" class="btn btn-xs btn-primary" onclick="openViewModel({{$message->id}})">View</button>                              
                                            <button type="button" class="btn btn-xs btn-info" onclick="openSendMail({{$message->id}})">Send Mail</button>                              
                                        </td>                                   	
                                    </tr>
                                    <div class="modal fade" id="exampleModalCenter{{$message->id}}">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Message</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{!! $message->message !!}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-xs btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-xs btn-info" onclick="openSendMail({{$message->id}})">Send Mail</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="replyMailModel{{$message->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Send Mail Message</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <form action="" method="">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" name="name" value={{$message->name}}>
                                                    <input type="hidden" name="email" value={{$message->email}}>
                                                    <div class="form-group">
                                                        <label>Reply Message</label>
                                                        <textarea class="form-control" name="reply" id="reply"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Reply</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-right">
                            	{{$messages->links()}}
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
<script>
    function openViewModel(id)
    {
        $('#exampleModalCenter'+id).modal('show');
    }
    function openSendMail(id)
    {
        $('#replyMailModel'+id).modal('show')
    }
</script>
@endsection