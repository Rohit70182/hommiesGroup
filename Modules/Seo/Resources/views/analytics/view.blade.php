@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">SEO Manager</li>
        <li class="active">Meta</li>
        <li class="active">Show Analytics</li>
    </ul>
</div>

<section class="content container-fluid">
    <div class="row">	
        <div class="col-md-12">
        
         <div class="page-head-text">
                <div class="ProfileHader d-flex flex-wrap align-items-center">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Show Analytics</h3>
                  
                    <a class="btn btn-bg ml-1" href="{{url('/seo/analytics/edit')}}/{{$analytics->id}}" title="edit"><span class="fa fa-pencil"></span></a>
                   <a class="btn btn-bg ml-1" href="{{url('/seo/analytics')}}"> Back</a>
                </div>

            </div>
        
            <div class="card">
<!--                 <div class="card-header "> -->
<!--                     <div class="float-left"> -->
<!--                         <span class=" font_600 font-18 font-md-20 mr-auto pr-20"> {{$analytics->title}}</span> -->
<!--                     </div> -->
<!--                     <div class="float-right"> -->
<!--                         <a class="btn btn-bg" href="{{url('/seo/analytics')}}" title="Manage"><span class="fa fa-list"></span></a> -->
<!--                         <a class="btn btn-bg" href="{{url('/seo/analytics/edit')}}/{{$analytics->id}}" title="Update"><span class="fa fa-pencil"></span></a> -->
<!--                     </div> -->
<!--                 </div> -->
                <div class="card-body col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="analytics-detail-view" class="table table-striped table-bordered detail-view">
                                            <tbody>
                                                <tr>
                                                    <th>Account</th>
                                                    <td colspan="1">{{$analytics->account}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Domain name</th>
                                                    <td colspan="1">{{$analytics->domain_name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created By</th>
                                                    <td colspan="1">{{$analytics->get_created_by->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Analytics Type</th>
                                                    <td colspan="1">{{$analytics->type}}</td>
                                                </tr>
                                                <tr>
                                                    <th>State</th>
                                                    <td colspan="1">{{$analytics->state}}</td>
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