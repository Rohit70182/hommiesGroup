@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">View Add On Services</li>
    </ul>
</div>

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="page-head-text d-flex flex-wrap justify-content-between ">
                    <div >
                        <span class=" font_600 font-18 font-md-20 mr-auto pr-20"> 
                        {{$add->name}}
                        </span>
                    </div>
                    <div >
                        <a href="{{url('/services/add-on/edit/'.$add->id)}}" title="edit users" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                                <a href="{{url('/services/add-on/remove/'.$add->id)}}" onclick="return confirm('Are you sure to delete it ?')" title="delete user" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
                    <a class="btn btn-bg ml-1" href="{{url('services/add-on')}}"> Back</a>
                    </div>
                    
                </div>
          
            <div class="card">
            
                <div class="card-body col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="redirect-detail-view" class="table table-striped table-bordered detail-view">
                                            <tbody>
                                                <tr>
                                                    <th>Id</th>
                                                    <td colspan="1">{{$add->id}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Name</th>
                                                    <td colspan="1">{{$add->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <td colspan="1">{{$add->desc}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Price</th>
                                                    <td colspan="1">{{$add->price}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Service Name</th>
                                                    <td colspan="1">{{ $add->getService ? $add->getService->name : '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>State</th>
                                                    <td colspan="1">{{$add->getState()}}</td>
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


