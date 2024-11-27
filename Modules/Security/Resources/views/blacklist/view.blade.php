@extends('admin.layouts.app')
@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                    <div class="float-left">
                        <span class=" font_600 font-18 font-md-20 mr-auto pr-20">{{$blacklist->ip}} </span>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-bg" href="{{url('security/blacklist/')}}" title="Manage"><span class="fa fa-list"></span></a>
                        <a class="btn btn-bg" href="{{url('security/blacklist/edit/'.$blacklist->id)}}" title="Update"><span class="fa fa-pencil"></span></a>
                    </div>
                </div>
                <div class="card-body col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="seo-detail-view" class="table table-striped table-bordered detail-view">
                                            <tbody>
                                                <tr>
                                                    <th>Id</th>
                                                    <td colspan="1">{{$blacklist->id}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Ip</th>
                                                    <td colspan="1">{{$blacklist->ip}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Reason Why</th>
                                                    <td colspan="1">{{$blacklist->reason}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Type</th>
                                                    <td colspan="1">{{$blacklist->getType()}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created On</th>
                                                    <td colspan="1">{{$blacklist->created_at}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Updated On</th>
                                                    <td colspan="1">{{$blacklist->updated_at}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created By</th>
                                                    <td colspan="1">{{$blacklist->created_by_id}}</td>
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