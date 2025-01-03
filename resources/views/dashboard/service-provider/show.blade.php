@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
	<ul class="breadcrumb">
		<li><a href="{{url('/dashboard')}}">Home</a></li>
		<li class="active">Service Provider</li>
	</ul>
</div>


<section class="content container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="page-head-text">
				<div class="ProfileHader d-flex flex-wrap align-items-center">
					<h3 class="font_600 font-18 font-md-20 mr-auto pr-20"> {{$show->name}}</h3>
					<div class="float-right">
					</div>
					<div class="float-right">
						<!-- <a href="{{url('dashboard/service/edit/'.$show->id)}}" title="edit service provider" class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a> -->
						<a href="{{url('dashboard/service/delete/'.$show->id)}}" onclick="return confirm('Are you sure to delete this service provider ?')" title="delete service provider" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
						<a class="btn btn-bg ml-1" href="{{url('dashboard/service')}}"> Back</a>

					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-body col-md-12">
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								@if($show->image)
								<img alt="img" title="" class=" isTooltip" src="{{url('public/uploads/'.$show->image)}}">
								@else
								<img alt="img" class=" isTooltip" src="{{ asset('public/assets/images/user.jpg') }}">
								@endif
							</div>
							<div class="col-md-8">
								<div class="table-responsive">
									<table class="table table-user-information table table-bordered">
										<tbody>
											<tr>
												<th>
													<span class="text-dark">Name</span>
												</th>
												<td>
													<span>{{$show->name}}</span>
												</td>

												<th>
													<span class="text-dark">Email </span>
												</th>
												<td>
													<span>{{$show->email}}</span>
												</td>
											</tr>
											<tr>
												<th>
													<span class="text-dark">DOB </span>
												</th>
												<td>
													<strong>
														<span class="text-dark"> </span>
														{{DateFormat($show->dob)}}
													</strong>
												</td>
												<th>
													<span class="text-dark">Address </span>
												</th>
												<td>
													<span>{{$show->address}}</span>
												</td>
											</tr>
											<tr>
												<th>
													<span class="text-dark">Phone</span>
												</th>
												<td>
													<span>{{$show->phone}}</span>
												</td>
												<th>
													<span class="text-dark">Created On </span>
												</th>
												<td>
													<span>{{$show->created_at}}</span>
												</td>

												</td>
											</tr>
											<tr>
												<th>
													<span class="text-dark">Role</span>
												</th>
												<td>
													<span>{{$show->getRole()}}</span>
												</td>
												<th>

												</th>
												<td>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-md-12">
								<div class="about" style="float:left;">
									<h5 style="padding:5px;">About:</h5>
									{{$show->getRole()}}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-body col-md-12">
					<div class="form-group">
						<div class="row">
							@if($show->id_proof_1)
							<div class="col-md-6">
								<h5 style="padding:5px;">ID Proof 1</h5>
								<img src="{{ $show->id_proof_1_url }}" alt="ID Proof 1" class="img-thumbnail" style="max-width: 100%; height: auto;">
							</div>
							@endif
							@if($show->id_proof_2)
							<div class="col-md-6">
								<h5 style="padding:5px;">ID Proof 2</h5>
								<img src="{{ $show->id_proof_2_url }}" alt="ID Proof 2" class="img-thumbnail" style="max-width: 100%; height: auto;">
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection