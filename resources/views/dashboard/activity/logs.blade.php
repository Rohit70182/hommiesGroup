@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">Logs</li>
    </ul>
</div>

<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Logs</h3>
          </div>
        </div>
        <div class="card-body table-responsive">
          <table id="ThemeTable" class="table table-bordered projects">
            <thead>
              <th>Id</th>
              <th>Instance</th>
              <th>Level</th>
              <th>User Agent</th>
              <th>Message</th>
              <th width="50px">Action</th>
            </thead>
            <tbody>
              @foreach($logs as $log)
              <tr>
                <td>{{$log->id}}</td>
                <td>{{$log->instance}}</td>
                <td>{{$log->level_name}}</td>
                <td>{{$log->user_agent}}</td>
                <td>{{$log->message}}</td>
                <td> <a href="{{url('dashboad/logs/delete/'.$log->id)}}" onclick="return confirm('Are you sure?')" title="delete post" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
              </tr>
              @endforeach
            </tbody>
          </table>
          {!! $logs->links() !!}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection