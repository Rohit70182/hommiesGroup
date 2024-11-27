@extends('admin.layouts.app')
@section('content')
<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Blacklists</h3>
                        <a class="btn btn-bg" href="{{ url('/security/blacklist/add') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="ThemeTable" class="table table-bordered projects">
                        <thead>
                            <th>ID</th>
                            <th>IP</th>
                            <th>Reason Why</th>
                            <th>State</th>
                            <th>Created On</th>
                            <th>Updated On</th>
                            <th width="210px">Actions</th>
                        </thead>
                        <tbody>
                            @foreach($blacklist as $blacklists)
                            <tr>
                                <td>{{$blacklists->id}}</td>
                                <td>{{$blacklists->ip}}</td>
                                <td>{{$blacklists->reason}}</td>
                                <td>{{$blacklists->getState()}}</td>
                                <td>{{$blacklists->created_at}}</td>
                                <td>{{$blacklists->updated_at}}</td>
                                <td> <a href="{{url('/security/blacklist/view/'.$blacklists->id)}}" title="view post" class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                                    <a href="{{url('/security/blacklist/edit/'.$blacklists->id)}}" title="edit post" class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a>
                                    <a href="{{url('/security/blacklist/delete/'.$blacklists->id)}}" onclick="return confirm('Are you sure?')" title="delete post" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
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