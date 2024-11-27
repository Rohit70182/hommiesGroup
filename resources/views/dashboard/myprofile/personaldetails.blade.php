@extends('admin.layouts.app')

@section('content')
<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">My Profile</li>
    </ul>
</div>

<div class="dash-home-cards">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<div class="ProfileHader d-flex flex-wrap align-items-center">
						<h3 class="font_600 font-18 font-md-20 mr-auto pr-20">My Profile</h3>
						<h5><a class=" btn btn-bg" href="{{url('dashboard/myprofile/edit/'.$userinfo->id)}}"><i class="fa fa-fw fa-edit"></i></a></h5>
					</div>
				</div>

				<div class="card-body">
					<div class="row">
<!-- 					<a class=" btn btn-bg" href="{{url('dashboard/myprofile/edit/'.$userinfo->id)}}"><i class="fa fa-fw fa-edit"></i></a> -->
						<div class="col-md-2 col-12">
							@if($userinfo->image)
							<img src="{{url('public/uploads/'.$userinfo->image)}}" class="profile">
							@else
							<img src="{{ asset('public/assets/images/user.jpg') }}" class="profile">
							@endif
						</div>
						<div class="col-md-10 col-12"> 
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<th>Id</th>
										<td>{{$userinfo->id}}</td>
										<th>Name</th>
										<td>{{$userinfo->name}}</td>
									</tr>
									
									<tr>
										<th>Email</th>
										<td class="text-primary">{{$userinfo->email}}</td>
										<th>Mobile</th>
										<td>{{$userinfo->phone}}</td>
<!-- 										<th>DOB</th> -->
<!-- 										<td>{{$userinfo->dob}}</td> -->
									</tr>
									<tr>
<!-- 										<th>Address</th> -->
<!-- 										<td>{{$userinfo->address}}</td> -->
<!-- 										<th>Mobile</th> -->
<!-- 										<td>{{$userinfo->phone}}</td> -->
									</tr>
									<tr>
										<th>Updated On</th>
										<td>{{DateFormat($userinfo->updated_at)}}</td>
										<th>Created On</th>
										<td>{{DateFormat($userinfo->created_at)}}</td>

									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

@endsection