<?php

use Modules\Services\Entities\CustomReq;

?>

@extends('admin.layouts.app')

@section('content')



<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">Show Custom Request</li>
    </ul>
</div>

<section class="content container-fluid">
	<div class="row">
		<div class="col-md-12">
		
		<div class="page-head-text">
                <div class="ProfileHader d-flex flex-wrap align-items-center">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">View Custom Request</h3>
                      <div class="float-right">
                     		<a href="{{url('/services/custom-req/remove/'.$custom->id)}}" onclick="return confirm('Are you sure to delete this custom request ?')" title="delete" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>

            			<a class="btn btn-bg" href="{{url('services/custom-req')}}"> Back</a>

    				</div>
                </div>
            </div>
		
			<div class="card">
<!-- 				<div class="card-header "> -->
<!-- 					<div class="float-left"> -->
<!-- 						<span class=" font_600 font-18 font-md-20 mr-auto pr-20"> {{$custom->name}}</span> -->
<!-- 					</div> -->
<!-- 				</div> -->
				<div class="card-body col-md-12">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<strong>Information</strong><br>
								<div class="table-responsive">
									<table class="table table-user-information">
										<tbody>
											<tr>
												<td>
													<strong>
														<span class="text-dark text-space">Id:</span>
														{{$custom->id}}
													</strong>
												</td>
											</tr>
											<tr>
												<td>
													<strong>
														<span class="text-dark text-space">Title:</span>
														{{$custom->name}}
													</strong>
												</td>
											</tr>

											<tr>
												<td>
													<strong>

														<span class="text-dark text-space">Description:</span>
														  {{$custom->desc}}

													</strong>
												</td>
											</tr>
											
											<tr>
												<td>
													<strong>


														<span class="text-dark text-space">Customer Name:</span>

														  {{$custom->user->name}}

													</strong>
												</td>
											</tr>
											
											
											<tr>
												<td>
													<strong>


														<span class="text-dark text-space">Customer Contact:</span>

														  {{ $custom->user->country_code }}-{{ $custom->user->phone }}

													</strong>
												</td>
											</tr>
											
											<tr>
												<td>
													<strong>


														<span class="text-dark text-space">Customer Email:</span>

														  {{ $custom->user->email }}

													</strong>
												</td>
											</tr>
																						
											<tr>
												<td>
													<strong>


														<span class="text-dark text-space">State:</span>

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

													</strong>
												</td>
											</tr>
											
											<tr>
												<td>
													<strong>

														<span class="text-dark">Images:</span>
														
														@foreach($reqImages as $reqImage)

															<img alt="img" title="image" class="'isTooltip" src="{{$reqImage}}" style="display:inline-block">

														@endforeach

													</strong>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					
				<div class="mt-3 float-right">	
					@if($custom->state_id == CustomReq::STATE_PENDING)				
								<a class="btn btn-bg" href="{{ url('/services/custom-req/status/'.$custom->id.'/'.CustomReq::STATE_ACCEPTED)}}">
								Approve
								</a>
								<a class="btn btn-bg" href="{{ url('/services/custom-req/status/'.$custom->id.'/'.CustomReq::STATE_REJECTED)}}">
								Decline
								</a>
					@endif	
					@if($custom->state_id == CustomReq::STATE_ACCEPTED)
								<a class="btn btn-bg" href="{{ url('/services/custom-req/status/'.$custom->id.'/'.CustomReq::STATE_REJECTED)}}">

								Decline
								</a>
					@endif	
					
					</div>
				</div>
				
			</div>
			
		</div>
	</div>
</section>
@endsection