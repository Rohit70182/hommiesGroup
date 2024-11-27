<?php

    use Modules\Services\Entities\CustomReq;

?>
@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Services</li>
        <li class="active">Custom Requests</li>
    </ul>
</div>

<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
    
    <div class="page-head-text">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Custom Requests</h3>
             @if (Auth::user() && Auth::user()->role == App\Models\User::ROLE_USER)
            <a class="btn btn-bg" href="{{ url('/services/custom-req/add') }}">
              <i class="fa fa-plus mr-1"></i>Add Custom Service
            </a>
            @endif
          </div>
     </div>
    
     <div class="page-index">
          Index
     </div>
    
      <div class="card">
        
        <div class="card-body table-responsive">
          <table id="datatable" class="table table-bordered projects">
            <thead>
              <th>Id</th>
              <th>Title</th>
              <th>Desc</th>
              <th>User-Name</th>
              <th>Status</th>
<!--               <th>Profile file</th> -->
<!--               <th>State</th> -->
              <th>Action</th>
            </thead>
            <tbody>
             @foreach($custom as $custom)
              <tr>
                <td>{{$custom->id}}</td>
                <td>{{$custom->name}}</td>
                <td>{{$custom->desc}}</td>
                <td>{{$custom->user->name}}</td>
				<td>
					@switch($custom->state_id)
						@case(CustomReq::STATE_ACCEPTED)
							Accepted
						@break;
						@case(CustomReq::STATE_REJECTED)
							Rejected
						@break;
						@default
							Pending
					@endswitch
				</td>

                <td>
                  <a href="{{url('/services/custom-req/show/'.$custom->id)}}" title="view " class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
<!--                   <a href="{{url('/services/custom-req/edit/'.$custom->id)}}" title="edit" class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a> -->
            	  <a href="{{url('/services/custom-req/remove/'.$custom->id)}}" onclick="return confirm('Are you sure to delete this custom request ?')" title="delete" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
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
        $('#datatable').DataTable({
            order: [
                [0, 'desc']
            ],
        });
    });
</script>
@endpush
