@extends('admin.layouts.app')
@section('content')
<section class="content container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header ">
					<div class="float-left">
						<span class=" font_600 font-18 font-md-20 mr-auto pr-20"> {{$custom->name}}</span>
					</div>
				</div>
				<div class="card-body col-md-12">
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<img alt="img"  title="" class=" isTooltip" src="{{url('public/uploads/'.$custom->image)}}">
							</div>
							<div class="col-md-9">
								<strong>Information</strong><br>
								<div class="table-responsive">
									<table class="table table-user-information">
										<tbody>
											<tr>
												<td>
													<strong>
														<span class="text-dark">Id:</span>
														{{$custom->id}}
													</strong>
												</td>
											</tr>
											<tr>
												<td>
													<strong>
														<span class="text-dark">Title:</span>
														{{$custom->name}}
													</strong>
												</td>
											</tr>

											<tr>
												<td>
													<strong>

														<span class="text-dark">Description:</span>
														  {{$custom->desc}}

													</strong>
												</td>
												<td class="text-primary">

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