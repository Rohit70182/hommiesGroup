@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="{{url('/dashboard')}}">Home</a></li>
         <li class="active">Manage</li>
         <li class="active">Login History</li>
      </ul>
</div>
<div class="dash-home-cards">
	<div class="row">
		<div class="col-12">
		<div class="page-head-text">
					<div class="ProfileHader d-flex flex-wrap align-items-center">
						<h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Login History</h3>
						 <a href="{{url('deleteLogs')}}" onclick="return confirm('Are you sure to delete all logs ?')"  class="btn btn-bg" >
                            <i class="fa fa-danger">Delete All Logs</i>
                        </a>
					</div>
				</div>
				<div class="page-index">
					Index
				</div>
			<div class="card">
			
				<div class="card-body table-responsive">
					<table class="table table-bordered" id="datatable">
						<thead>
							<th>serial</th>
							<th>URL</th>
							<th>Method</th>
							<th>User Ip</th>
							<th width="300px">User Agent</th>
							<th>User Id</th>
							<th>Time</th>
<!-- 							 <th>State</th> -->
							<th>Actions</th>
						</thead>
						@if($logs->count())
						<tbody>
							@foreach($logs as $key => $log)
							<tr>
								<td>{{ $log->id }}</td>
								<td class="text-primary">{{ $log->url }}</td>
								<td><label class="label label-info">{{ $log->method }}</label></td>
								<td class="text-warning">{{ $log->ip }}</td>
								<td class="text-danger">{{ $log->agent }}</td>
								<td>{{ $log->user_id }}</td>
								<td>{{ $log->created_at}}</td>
<!-- 								<td>{{ $log->state_id }}</td> -->
								<td> 
								<a href="{{ url('/logActivity/logShow/'.$log->id) }}" title="view log activity" class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
								<a href="{{ url('/logActivity/delete/'.$log->id) }}" onclick="return confirm('Are you sure you want to delete?')" title="delete" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>

								</td>
							</tr>
							@endforeach
						</tbody>
						@endif
					</table>
					{!! $logs->links() !!}
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@push('styles')
<!-- Data Table CSS -->
<link rel="stylesheet" href="{{asset('public/dataTables/dataTables.min.css')}}">
@endpush

@push('scripts')
<!-- Data Table Script -->
<script src="{{asset('public/dataTables/dataTables.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
        order: [[0, 'DESC']],
"bPaginate": false
    });
    });
</script>

@endpush