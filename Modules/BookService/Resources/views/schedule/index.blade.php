@extends('admin.layouts.app')
@section('content')
<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Services</h3>
            <a class="btn btn-bg" href="{{ url('/booking/schedule/add') }}">
              <i class="fa fa-plus mr-1"></i>Schedule Service
            </a>
          </div>
        </div>
        <div class="card-body table-responsive">
          <table id="ThemeTable" class="table table-bordered projects">
            <thead>
              <th>Id</th>
              <th>Service</th>
              <th>Service Provider</th>
              <th>Date</th>
              <th>Start-Time</th>
              <th>End_Time</th>
              <th>Address</th>
              <th>Status</th>
              <th>Actions</th>
            </thead>
            <tbody>
            @foreach($schedule as $schedule)
              <tr>
                <td>{{$schedule->id}}</td>
                <td>{{$schedule->service_id}}</td>
                <td>{{$schedule->provider_id}}</td>
                <td>{{$schedule->date}}</td>
                <td>{{$schedule->start_time}}</td>
                <td>{{$schedule->end_time}}</td>
                <td>{{$schedule->address}}</td>
                <td>{{$schedule->state_id}}</td>
                <td>
                  <a href="{{url('/booking/schedule/show/'.$schedule->id)}}" title="view " class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                  <a href="{{url('/booking/schedule/edit/'.$schedule->id)}}" title="edit" class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a>
                  <a href="{{url('/booking/schedule/remove/'.$schedule->id)}}" onclick="return confirm('Are you sure?')" title="delete custom service" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
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