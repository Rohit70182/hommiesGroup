<?php use App\Models\CancelReason; ?>
@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Cancel Reasons</li>
    </ul>
</div>

<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
        
        <div class="page-head-text">
                     <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Cancel Reasons</h3>
                        <a class="btn btn-bg" href="{{route('createreason')}}">
                            <i class="fa fa-plus"></i>
                        </a>

                    </div>
                </div>
                <div class="page-index">
                Index
                </div>
        
            <div class="card">
                <div class="card-header">
                    <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Cancel Reasons</h3>
                    </div>

                </div>
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project">
                        <thead>
                            <th>Id</th>
                            <th>Reason</th>
                            <th>State</th>
                            <th>Actions</th>  
                        </thead>
                        <tbody>
                     		@foreach($cancelReasons as $key=>$cancelReason)
                     			<tr>
                     				<td>{{ $cancelReason->id }}</td>
                     				<td>{{ $cancelReason->messages }}</td>
                     				@if($cancelReason->state_id == CancelReason::STATE_ACTIVE)
                     					<td>Active</td>
                     				@endif
                     				<td>
                     					<a href="{{route('showreason' ,$cancelReason->id)}}" title="view" class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                                    	<a href="{{url('cancel-reasons/edit/' . $cancelReason->id)}}" title="edit" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                                    	<a href="{{route('deletereason' , $cancelReason->id)}}" onclick="return confirm('Are you sure you want to delete it ?')" title="change state"" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
                     				</td>
                     			</tr>
                     		@endforeach
                        </tbody>
                    </table>
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
        $('#datatable').DataTable();
    });
</script>
@endpush