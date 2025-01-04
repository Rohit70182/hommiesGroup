@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
	<ul class="breadcrumb">
		<li><a href="{{url('/dashboard')}}">Home</a></li>
		<li class="active">Property</li>
	</ul>
</div>


<section class="content container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="page-head-text">
				<div class="ProfileHader d-flex flex-wrap align-items-center">
					<h3 class="font_600 font-18 font-md-20 mr-auto pr-20"> {{$property->name}}</h3>
					<div class="float-right">
					</div>
					<div class="float-right">
						<a href="{{url('dashboard/property/delete/'.$property->id)}}" onclick="return confirm('Are you sure to delete this user ?')" title="delete user" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
						<a class="btn btn-bg ml-1" href="{{url('dashboard/property')}}"> Back</a>

					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-body col-md-12">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table table-user-information table table-bordered">
										<tbody>
											<tr>
												<th>
													<span class="text-dark">Property Name</span>
												</th>
												<td>
													<span>{{$property->name ? $property->name : '-'}}</span>
												</td>

												<th>
													<span class="text-dark">No of Rooms </span>
												</th>
												<td>
													<span>{{$property->no_of_rooms ? $property->no_of_rooms: '-'}}</span>
												</td>
											</tr>

											<tr>
												<th>
													<span class="text-dark">Area</span>
												</th>
												<td>
													<span>{{$property->area ? $property->area :'-'}}</span>
												</td>

												<th>
													<span class="text-dark">Price Type </span>
												</th>
												<td>
													<span>{{$property->getPrice()}}</span>
												</td>
											</tr>

											<tr>
												<th>
													<span class="text-dark">No of Bathrooms</span>
												</th>
												<td>
													<span>{{$property->bathrooms ? $property->bathrooms: '-'}}</span>
												</td>

												<th>
													<span class="text-dark">Adult</span>
												</th>
												<td>
													<span>{{$property->adult ? $property->adult :'-'}}</span>
												</td>
											</tr>
											<tr>
												<th>
													<span class="text-dark">Children</span>
												</th>
												<td>
													<span>{{$property->children ? $property->children : '-'}}</span>
												</td>

												<th>
													<span class="text-dark">Infants</span>
												</th>
												<td>
													<span>{{$property->infants ? $property->infants : '-'}}</span>
												</td>
											</tr>

											<tr>
												<th>
													<span class="text-dark">No of Beds </span>
												</th>
												<td>
													<strong>
														<span class="text-dark"> </span>
														{{$property->no_of_beds ? $property->no_of_beds : '-'}}
													</strong>
												</td>
												<th>
													<span class="text-dark">Price </span>
												</th>
												<td>
													<span>{{ $property->price ? '$' . number_format($property->price, 2) : '-' }}</span>
												</td>

											</tr>
											<tr>
												<th>
													<span class="text-dark">Address</span>
												</th>
												<td>
													<span>{{$property->address ? $property->address : '-'}}</span>
												</td>
												<th>
													<span class="text-dark">Town </span>
												</th>
												<td>
													<span>{{$property->town ? $property->town : '-'}}</span>
												</td>

												</td>
											</tr>
											<tr>
												<th>
													<span class="text-dark">Zipcode</span>
												</th>
												<td>
													<span>{{$property->zipcode ? $property->zipcode : '-'}}</span>
												</td>
												<th>
													<span class="text-dark">Country</span>
												</th>
												<td>
													<span>{{$property->country ? $property->country : '-'}}</span>
												</td>
											</tr>

											<tr>
												<th>
													<span class="text-dark">Status</span>
												</th>
												<td>
													<span>{{$property->getState()}}</span>
												</td>
												<th>
													<span class="text-dark">Property Type</span>
												</th>
												<td>
													<span>{{$property->getType()}}</span>
												</td>
											</tr>
											<tr>
												<th>
													<span class="text-dark">Rating</span>
												</th>
												<td>
													<span>{{$property->rating ? $property->rating : '-'}}</span>
												</td>
												<th>
													<span class="text-dark">Sold To</span>
												</th>
												<td>
													<span>{{$property->sold_to ? $property->sold_to : '-'}}</span>
												</td>
											</tr>
											<tr>
												<th>
													<span class="text-dark">Created By</span>
												</th>
												<td>
													<span>{{$property->user ? $property->user->name : '-'}}</span>
												</td>
												<th>
													<span class="text-dark">Created On</span>
												</th>
												<td>
													<span>{{ DateFormat($property->created_at) }}</span>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="row">
									<div class="col-md-12 mb-3">
										<h3>About Property :</h3>
										<p>{{$property->about ? $property->about : '-'}}</p>
									</div>
									<div class="col-md-6">
										<h3>Property Id Image 1:</h3>
										<img src="{{ $property->getPropertyIdProof1UrlAttribute() ? $property->getPropertyIdProof1UrlAttribute() : asset('public/assets/images/default-image.jpg') }}" alt="Property Image 1" style="max-width:100%;" class="img-fluid">
									</div>
									<div class="col-md-6">
										<h3>Property Id Image 2:</h3>
										<img src="{{ $property->getPropertyIdProof2UrlAttribute() ? $property->getPropertyIdProof2UrlAttribute() : asset('public/assets/images/default-image.jpg') }}" alt="Property Image 2" style="max-width:100%;" class="img-fluid">
									</div>
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
							<div class="col-md-12">
								<h3 class="mt-2">Property Images:</h3>
								<div class="row">
									@if($property->getPropertyImagesUrlAttribute()->isEmpty())
									<!-- Show default image if no property images -->
									<div class="col-md-4 mb-3">
										<img src="{{ asset('public/assets/images/default-image.jpg') }}" alt="Default Property Image" class="img-fluid" style="margin-bottom: 10px;">
									</div>
									@else
									@foreach($property->getPropertyImagesUrlAttribute() as $imageUrl)
									<div class="col-md-4 mb-3">
										<img src="{{ $imageUrl }}" alt="Property Image" class="img-fluid" style="margin-bottom: 10px;">
									</div>
									@endforeach
									@endif
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
							<div class="col-md-12">
								<h3 class="mt-2">Property Amenities:</h3>
								<div class="row">
									@if($property->getPropertyAmanitiesImgNameAttribute()->isEmpty())
									<div class="col-md-3 mb-3 text-center">
										<img src="{{ asset('public/assets/images/default-image.jpg') }}" alt="Default Amenity Image" class="img-fluid" style="max-width:100%; margin-bottom: 10px;">
										<p>No amenities available</p>
									</div>
									@else
									@foreach($property->getPropertyAmanitiesImgNameAttribute() as $amenity)
									<div class="col-md-3 mb-3 text-center">
										<img src="{{ $amenity['image_url'] }}" alt="Amenity Image" class="img-fluid" style="max-width:100%; margin-bottom: 10px;">
										<p>{{ $amenity['name'] }}</p>
									</div>
									@endforeach
									@endif
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
							<div class="col-md-12">
								<h3 class="mt-2">Testimonials:</h3>
								<div class="table-responsive">
									<table class="table table-bordered table-user-information">
										<thead>
											<tr>
												<th><span class="text-dark">Comment</span></th>
												<th><span class="text-dark">Rating</span></th>
												<th><span class="text-dark">Created By</span></th>
												<th><span class="text-dark">Created On</span></th>
											</tr>
										</thead>
										<tbody>
											@forelse($property->testimonials as $testimonial)
											<tr>
												<td>
													<span>{{ $testimonial->title ?? '-' }}</span>
												</td>
												<td>
													<span>{{ $testimonial->rating ?? '-' }}</span>
												</td>
												<td>
													<span>{{ $testimonial->getUser->name ?? 'Anonymous' }}</span>
												</td>
												<td>
													<span>{{ $testimonial->created_at ? $testimonial->created_at->format('d M Y') : '-' }}</span>
												</td>
											</tr>
											@empty
											<tr>
												<td colspan="4">No testimonials available for this property.</td>
											</tr>
											@endforelse
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