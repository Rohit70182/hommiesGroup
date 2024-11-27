@extends('admin.layouts.app')
@section('content')
<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Whitelists</h3>
                        <a class="btn btn-bg" href="{{ url('/security/whitelist/add') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="ThemeTable" class="table table-bordered projects">
                        <thead>
                            <th>ID</th>
                            <th>IP</th>
                            <th>User</th>
                            <th>State</th>
                            <th>Created On</th>
                            <th>Updated On</th>
                            <th width="210px">Actions</th>
                        </thead>
                        <tbody>
                            @foreach($whitelist as $whitelists)
                            <tr>
                                <td>{{$whitelists->id}}</td>
                                <td>{{$whitelists->ip}}</td>
                                <td>{{$whitelists->getUser->name}}</td>
                                <td>{{$whitelists->getState()}}</td>
                                <td>{{$whitelists->created_at}}</td>
                                <td>{{$whitelists->updated_at}}</td>
                                <td><a href="{{url('/security/whitelist/view/'.$whitelists->id)}}" title="view" class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a> 
                                    <a href="{{url('/security/whitelist/edit/'.$whitelists->id)}}" title="edit" class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a>
                                    <a href="{{url('/security/whitelist/delete/'.$whitelists->id)}}" onclick="return confirm('Are you sure?')" title="delete" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
                                    
                                </td>
                            </tr>
                            @endforeach
                        <tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection