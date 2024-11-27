@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">SEO Manager</li>
        <li class="active">Redirect</li>
        <li class="active">Show Redirect</li>
    </ul>
</div>

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
        
         <div class="page-head-text">
                <div class="ProfileHader d-flex flex-wrap align-items-center">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Show Redirect</h3>
                  
                    <a class="btn btn-bg ml-1" href="{{url('/seo/redirect/edit')}}/{{$redirect->id}}" title="edit"><span class="fa fa-pencil"></span></a>
                   <a class="btn btn-bg ml-1" href="{{url('/seo/redirect')}}"> Back</a>
                </div>

            </div>
        
            <div class="card">
<!--                 <div class="card-header "> -->
<!--                     <div class="float-left"> -->
<!--                         <span class=" font_600 font-18 font-md-20 mr-auto pr-20"> {{$redirect->title}}</span> -->
<!--                     </div> -->
<!--                     <div class="float-right"> -->
<!--                         <a class="btn btn-bg" href="{{url('/seo/redirect')}}" title="Manage"><span class="fa fa-list"></span></a> -->
<!--                         <a class="btn btn-bg" href="{{url('/seo/redirect/edit')}}/{{$redirect->id}}" title="Update"><span class="fa fa-pencil"></span></a> -->
<!--                     </div> -->
<!--                 </div> -->
                <div class="card-body col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="redirect-detail-view" class="table table-striped table-bordered detail-view">
                                            <tbody>
                                                <tr>
                                                    <th>Old Url</th>
                                                    <td colspan="1">{{$redirect->old_url}}</td>
                                                </tr>
                                                <tr>
                                                    <th>New Url</th>
                                                    <td colspan="1">{{$redirect->new_url}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created By</th>
                                                    <td colspan="1">{{$redirect->get_created_by->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>State</th>
                                                    <td colspan="1">{{$redirect->state}}</td>
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