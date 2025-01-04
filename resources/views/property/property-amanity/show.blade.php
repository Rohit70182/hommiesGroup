@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
	<ul class="breadcrumb">
		<li><a href="{{url('/dashboard')}}">Home</a></li>
		<li class="active">Amenity</li>
	</ul>
</div>


<section class="content container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="page-head-text">
				<div class="ProfileHader d-flex flex-wrap align-items-center">
					<h3 class="font_600 font-18 font-md-20 mr-auto pr-20"> {{$amenity->name}}</h3>
					<div class="float-right">
					</div>
					<div class="float-right">
						<a href="{{url('dashboard/amenity/delete/'.$amenity->id)}}" onclick="return confirm('Are you sure to delete this amanity ?')" title="delete user" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
						<a class="btn btn-bg ml-1" href="{{url('dashboard/amenity')}}"> Back</a>

					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header ">

				</div>
				<div class="card-body col-md-12">
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								@if($amenity->image)
								<img alt="img" title="" class=" isTooltip" src="{{$amenity->getAmanitiesImageAttribute()}}">
								@else
								<img alt="img" class=" isTooltip" src="{{ asset('public/assets/images/user.jpg') }}">
								@endif
							</div>
							<div class="col-md-8">
								<!-- <strong>Information</strong><br> -->
								<div class="table-responsive">
									<table class="table table-user-information table table-bordered">
										<tbody>
											<tr>
												<th>
													<span class="text-dark">Name</span>
												</th>
												<td>
													<span>{{$amenity->name ? $amenity->name : '-'}}</span>
												</td>

												<th>
													<span class="text-dark">State </span>
												</th>
												<td>
													<span>{{$amenity->getState()}}</span>
												</td>
											</tr>
											<tr>
												<th>
													<span class="text-dark">Created On </span>
												</th>
												<td>
													<strong>
														<span class="text-dark"> </span>
														{{DateFormat($amenity->created_at)}}
													</strong>
												</td>
												<th>
													<span class="text-dark">Created By </span>
												</th>
												<td>
													<span>{{$amenity->user ? $amenity->user->name : '-'}}</span>
												</td>

											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>
@endsection