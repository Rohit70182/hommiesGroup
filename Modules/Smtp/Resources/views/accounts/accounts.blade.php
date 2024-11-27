@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="{{url('/dashboard')}}">Home</a></li>
         <li class="active">Manage</li>
         <li class="active">SMTP</li>
      </ul>
</div>

<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
    <div class="page-head-text">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Accounts</h3>
            <a class="btn btn-bg" href="{{url('/smtp/add')}}">
              <i class="fa fa-plus"></i>
            </a>
          </div>

        </div>
        <div class="page-index">
          Index
        </div>
      <div class="card">
     
        <div class="card-body table-responsive">
          <table id="ThemeTable" class="table table-bordered projects">
            <thead>
              <th>Id</th>
              <th>title</th>
              <th>Email</th>
              <th>Server</th>
              <th>Port</th>
              <th>Encryption Type</th>
              <th>State </th>
              <th>Type</th>
              <th>Created On</th>
              <th>Actions</th>
            </thead>
            <tbody>
              @foreach($accounts as $account)
              <tr>
                <td>{{$account->id}}</td>
                <td>{{$account->title}}</td>
                <td>{{$account->email}}</td>
                <td>{{$account->server}}</td>
                <td>{{$account->port}}</td>
                <td>{{$account->getEncryption()}}</td>
                <td>{{$account->getState()}}</td>
                <td>{{$account->getType()}}</td>
                <td>{{$account->created_at}}</td>
                <td><a href="{{url('smtp/edit/'.$account->id)}}" title="edit post" class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a>
                   <a href="{{url('smtp/delete/'.$account->id)}}" onclick="return confirm('Are you sure?')" title="delete post" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
                  
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