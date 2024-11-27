@extends('admin.layouts.app')
@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                    <div class="float-left">
                        <span class=" font_600 font-18 font-md-20 mr-auto pr-20">{{$whitelist->ip}} </span>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-bg" href="{{url('security/whitelist')}}" title="Manage"><span class="fa fa-list"></span></a>
                        <a class="btn btn-bg" href="{{url('security/whitelist/edit/'.$whitelist->id)}}" title="Update"><span class="fa fa-pencil"></span></a>
                    </div>
                </div>
                <div class="card-body col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered detail-view">
                                            <tbody>
                                                <tr>
                                                    <th>Id</th>
                                                    <td colspan="1">{{$whitelist->id}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Ip</th>
                                                    <td colspan="1">{{$whitelist->ip}}</td>
                                                </tr>
                                                <tr>
                                                    <th>User</th>
                                                    <td colspan="1">{{$whitelist->getUser->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Type</th>
                                                    <td colspan="1">{{$whitelist->getType()}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered detail-view">
                                            <tbody>
                                                <tr>
                                                    <th>Created On</th>
                                                    <td colspan="1">{{$whitelist->created_at}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Updated On</th>
                                                    <td colspan="1">{{$whitelist->updated_at}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created By</th>
                                                    <td colspan="1">{{$whitelist->created_by_id}}</td>
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
    </div>
</section>
@endsection