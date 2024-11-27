@extends('admin.layouts.app')
@section('content')
<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Custom Services</h3>
            <a class="btn btn-bg" href="{{ url('/booking/custom/add') }}">
              <i class="fa fa-plus mr-1"></i>Add Custom Service
            </a>
          </div>
        </div>
        <div class="card-body table-responsive">
          <table id="ThemeTable" class="table table-bordered projects">
            <thead>
              <th>Id</th>
              <th>Title</th>
              <th>Desc</th>
              <th>Status</th>
              <th>Profile file</th>
              <th>Action</th>
            </thead>
            <tbody>
             @foreach($custom as $custom)
              <tr>
                <td>{{$custom->id}}</td>
                <td>{{$custom->name}}</td>
                <td>{{$custom->desc}}</td>
                <td>{{$custom->getStateAttribute()}}</td>
                <td>
                  <img src="{{url('public/uploads/'.$custom->image)}}" width="40px" height="40px" style="border-radius:50%">        
                </td>
                <td>
                  <a href="{{url('/booking/custom/show/'.$custom->id)}}" title="view " class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                  <a href="{{url('/booking/custom/edit/'.$custom->id)}}" title="edit" class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a>
                  <a href="{{url('/booking/custom/remove/'.$custom->id)}}" onclick="return confirm('Are you sure?')" title="delete custom service" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
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