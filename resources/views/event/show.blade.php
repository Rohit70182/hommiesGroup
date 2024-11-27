@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>	
        <li class="active">Show Event</li>
    </ul>
</div>

<section class="content container-fluid">
	<div class="row">
		<div class="col-md-12">
		<div class="page-head-text d-flex flex-wrap justify-content-between">
					<div >
						<span class=" font_600 font-18 font-md-20 mr-auto pr-20">Show Event</span>
					</div>
					<div >
					<a href="{{url('edit/'.$events->id)}}" title="edit " class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a>
              					<a href="{{url('delete/'.$events->id)}}" onclick="return confirm('Are you sure to delete this event ?')" title="delete" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
								
                            <a class="btn btn-bg" href="{{url('event/list')}}"> Back</a>
                    </div>
				</div>
				
			<div class="card">
				
				<div class="card-body col-md-12">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								
								<div class="table-responsive">
									<table class="table table-bordered">
										<tbody>
											<tr>
												<th><span class="text-dark">Id </span></th>
												<td>
												{{$events->id}}
												</td>

											</tr>
											<tr>
											<th><span class="text-dark">Title </span></th>
												<td>
													
													
														{{$events->title}}
													
												</td>
											</tr>

											<tr>
											<th><span class="text-dark">State </span></th>
												<td>
													
														{{$events->getStateAttribute()}}
													
												</td>
											</tr>
											<tr>
											<th><span class="text-dark">Service </span></th>
												<td>
												
														{{ $events->getService() }}
													
												</td>
											</tr>
											<tr>
											<th><span class="text-dark">Price: </span></th>
												<td>
												
														{{ $events->price }}
													
												</td>
											</tr>
											<tr>
											<th><span class="text-dark">Description: </span></th>
												<td>
												
														{{ $events->desc }}
													
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