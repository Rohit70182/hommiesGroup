@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">View Sub Category</li>
    </ul>
</div>

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="page-head-text d-flex flex-wrap justify-content-between">
                <div>
                    <span class=" font_600 font-18 font-md-20 mr-auto pr-20">View Sub Category</span>
                </div>
                <div>
                    <a href="{{url('/services/sub-category/edit/'.$subcategory->id)}}" title="edit users" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                    <a href="{{url('/services/sub-category/remove/'.$subcategory->id)}}" onclick="return confirm('Are you sure to delete this subcategory ?')" title="delete user" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>

                    <a class="btn btn-bg" href="{{url('services/sub-category')}}"> Back</a>
                </div>
            </div>
            <div class="page-index">Index</div>
            <div class="card">

                <div class="card-body col-md-12">
                    <div class="form-group">
                        <div class="row">
                         <div class="col-md-3 mt-2">
								@if($subcategory->image)
								<img alt="img" title="" class=" isTooltip" src="{{url('public/uploads/'.$subcategory->image)}}">
								@else
								<img alt="img" class=" isTooltip" src="{{ asset('public/assets/images/user.jpg') }}">
								@endif
							</div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="seo-detail-view" class="table table-striped table-bordered detail-view">
                                            <tbody>
                                                <tr>
                                                    <th>Sub-Category Title</th>
                                                    <td colspan="1">{{$subcategory->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <td colspan="1">{{$subcategory->desc}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Category</th>
                                                    <td colspan="1">{{$subcategory->getCategory->name}}</td>
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