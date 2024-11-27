@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
	<ul class="breadcrumb">
		<li><a href="/project/tunesline-yii2-1786/">Home</a></li>
		<li class="active">Show Service Provider</li>
	</ul>
</div>


<section class="content container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="page-head-text d-flex flex-wrap justify-content-between">
				<div>
					<span class=" font_600 font-18 font-md-20 mr-auto pr-20">Service Provider</span>
				</div>
				<div>
					<a href="{{url('/serviceProvider/edit/'.$provider->id)}}" title="edit " class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a>
					<a href="{{url('/serviceProvider/delete/'.$provider->id)}}" onclick="return confirm('Are you sure to delete this service provider ?')" title="delete" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
					<a class="btn btn-bg" href="{{url('serviceProvider')}}"> Back</a>
				</div>
			</div>
			
			<div class="card">

				<div class="card-body col-md-12">
					<div class="form-group">
						<div class="row">
							<div class="col-md-2 mt-2">
								@if($provider->image)
								<img alt="img" title="image" class=" isTooltip" src="{{url('public/uploads/'.$provider->image)}}">
								@else
								<img alt="img" title="image"  class=" isTooltip" src="{{ asset('public/assets/images/user.jpg') }}">
								@endif
							</div>
							
								<div class="col-md-2 mt-2">
								@if($provider->certifications)
								<img alt="img" title="certificate"class=" isTooltip" src="{{url('public/uploads/'.$provider->certifications)}}">
								@else
								<img alt="img" class=" isTooltip" title="certificate" src="{{ asset('public/assets/images/user.jpg') }}">
								@endif
							</div>
							<div class="col-md-8">
								<div class="table-responsive">
									<table class="table table table-bordered">
										<tbody>
											<tr>
												<th>
													<strong>
														<span class="text-dark">Name </span>
													</strong>
												</th>
												<td>
													<strong>
														{{$provider->name}}
													</strong>

												</td>
												<th>
													<strong>
														<span class="text-dark">DOB </span>
													</strong>
												</th>
												<td>
													<strong>
														{{$provider->dob}}
													</strong>
												</td>
											</tr>


											<tr>
												<th>
													<strong>
														<span class="text-dark">Address </span>
													</strong>
												</th>
												<td>
													<strong>
														{{ $provider->address}}
													</strong>
												</td>
												<th>
													<strong>
														<span class="text-dark">Gender </span>
													</strong>
												</th>
												<td>
													<strong>
														{{$provider->gender}}
													</strong>
												</td>
											</tr>

											<tr>
												<th>
													<strong>
														<span class="text-dark">Contact </span>
													</strong>
												</th>
												<td>
													<strong>
														{{$provider->phone}}
													</strong>
												</td>
												<th>
													<strong>
														<span class="text-dark">Experience </span>
													</strong>
												</th>
												<td>
													<strong>
														{{$provider->experience}} years
													</strong>
												</td>
											</tr>

											<tr>
												<th>
													<strong>
														<span class="text-dark">Working Hours </span>
													</strong>
												</th>
												<td>
													<strong type="input">
														{{TimeFormat($provider->start_time)}} -- {{TimeFormat($provider->end_time)}}
													</strong>
												</td>
												<th>
													<strong>
														<span class="text-dark">Services</span>
													</strong>
												</th>
												<td>
													@foreach($serviceNames as $serviceName)
														{{ $serviceName }},
													@endforeach
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

@if($provider->comments->isNotEmpty() )
 <div class="page-index">
                Index
            </div>
            <div class="card">

                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project
                    ">
                        <thead>
                            <th>Id</th>
                            <th>Service Name</th>
                            <th>State</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                    
                            @foreach($provider->comments as $service)
                            <tr>
                                <td>{{$service->id}}</td>
                                <td>{{$service->title}}</td>
                                <td>{{$service->type_id}}</td>
                                <td>
                                    <a href="{{url('/services/show/'.$service->id)}}" title="view" class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                                    <a href="{{url('/services/edit/'.$service->id)}}" title="edit" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="{{url('/services/softDelete/'.$service->id)}}" onclick="return confirm('Are you sure to change its state ?')" title="change state" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
@endsection