@extends('admin.layouts.app')
@section('content')
<?php
use Modules\Services\Entities\SubService;
use Modules\Services\Entities\Service;
?>

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Show Service</li>
    </ul>
</div>

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="page-head-text">
                <div class="ProfileHader d-flex flex-wrap align-items-center">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Show Service</h3>
                    
                    <a href="{{url('/services/remove/'.$service->id)}}" onclick="return confirm('Are you sure to delete this service ?')" title="delete service" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
                    <a class="btn btn-bg ml-1" href="{{url('/services/edit/'.$service->id)}}" title="Modify"><span class="fa fa-pencil"></span></a>
                    <a class="btn btn-bg ml-1" href="{{url('services')}}"> Back</a>
                </div>

            </div>
            <div class="card">
                
                <div class="card-body col-md-12 mt-2">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                            	@if($service->image)
								<img alt="img" title="" class=" isTooltip" src="{{url('public/uploads/'.$service->image)}}">
								@else
								<img alt="img" class=" isTooltip" src="{{ asset('public/assets/images/user.jpg') }}">
								@endif
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="analytics-detail-view" class="table table-striped table-bordered detail-view">
                                            <tbody>
                                                <tr>
                                                    <th>Service Name</th>
                                                    <td colspan="1">{{$service->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <td colspan="1">{{$service->desc}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Category</th>
                                                    <td colspan="1">{{$service->category_id ? $service->getCategory->name: ''}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Sub category</th>
                                                    <td colspan="1">{{$service->category_id ? $service->getSubCategory->name: ''}}</td>
                                                </tr>
                                                <tr>
                                                    <th>State</th>
                                                    <td colspan="1">{{$service->getStateid()}}</td>
                                                </tr>
                                                <tr></tr>
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
    </div>
</section>
<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
            <div class="page-head-text">
                <div class="ProfileHader d-flex flex-wrap align-items-center">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Sub Services</h3>
                    <a class="btn btn-bg" href="{{url('/services/add/sub-service/'.$service->id)}}">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>

            </div>
            <div class="page-index">
                Sub Services
            </div>
            <div class="card">

                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project
                    ">
                        <thead>
                            <th>Id</th>
                            <th>Sub Service Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>State</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php
                                $subServices = SubService::where('service_id',$service->id)->get();
                            ?>
                            @foreach($subServices as $key=>$subService)
                            	<tr>
                            		<td>{{ $key+1 }}</td>
                            		<td>{{ $subService->sub_service_name }}</td>
                            		<td>{{ $subService->description }}</td>
                                    <td>@if($subService->price) {{$subService->price}} @else No price added @endif  </td>
                            		@if($subService->state_id == SubService::STATE_ACTIVE)
                            			<td>Active</td>
                            		@else
                            			<td>Inactive</td>
                            		@endif
                            		<td>
                                        <a href="{{ url('/services/edit/sub-service/'.$subService->id) }}" title="edit" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ url('/services/delete/sub-service/'.$subService->id) }}" onclick="return confirm('Are you sure you want to delete?')" title="change state" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
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