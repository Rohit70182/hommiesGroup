@extends('admin.layouts.app')
@section('content')
<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">View Category</li>
    </ul>

</div>


<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            <div class="page-head-text">
                <div class="ProfileHader d-flex flex-wrap align-items-center">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">View Category</h3>
                      <div class="float-right">
                      
                             <a href="{{url('/services/category/edit/'.$category->id)}}" title="edit category" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                                
                     			<a href="{{url('/services/category/remove/'.$category->id)}}" onclick="return confirm('Are you sure to delete this category ?')" title="delete user" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>


            			<a class="btn btn-bg" href="{{url('services/category')}}"> Back</a>

    				</div>
                </div>
            </div>
            <div class="card">
                <div class="card-body col-md-12">
                    <div class="form-group">
                        <div class="row">
                        <div class="col-md-3 mt-2">
								@if($category->image)
								<img alt="img" title="" class=" isTooltip" src="{{url('public/uploads/'.$category->image)}}">
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
                                                    <th>Id</th>
                                                    <td colspan="1">{{$category->id}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Category name</th>
                                                    <td colspan="1">{{$category->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <td colspan="1">{{$category->desc}}</td>
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
@endsection