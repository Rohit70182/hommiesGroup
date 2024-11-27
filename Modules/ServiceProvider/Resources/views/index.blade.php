@extends('admin.layouts.app')
@section('content')
<div class="mb-1 mt-2">
      <ul class="breadcrumb">
         <li><a href="{{url('/dashboard')}}">Home</a></li>
         <li class="active">Service Providers</li>
      </ul>
</div>

<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
    <div class="page-head-text">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Service Providers</h3>
            <a class="btn btn-bg" href="{{url('/serviceProvider/create')}}">
              <i class="fa fa-plus mr-1"></i>Add Service Provider
            </a>
          </div>
        </div>
        <div class="page-index">
          Index
        </div>
      <div class="card">
      
        <div class="card-body table-responsive">
          <table id="datatable" class="table table-bordered projects">
            <thead>
              <th>Id</th>
              <th>Name</th>
              <th>DOB</th>
              <th>Gender</th>
              <th>Address</th>
              <th>Working Hours</th>
              <th>Contact</th>	
              <th>State</th>	
              <th>Actions</th>
            </thead>
            <tbody>
             @foreach ($provider as $user)
              <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name}}</td>
                <td>{{ $user->date_of_birth}}</td>
                <td>{{ $user->getGender()}}</td>
                <td>{{ $user->address}}</td>
                <td>{{TimeFormat($user->start_time)}} -- {{TimeFormat($user->end_time)}}</td>
                <td>{{$user->contact}}</td>
                <td>{{$user->getState()}}</td>
                <td>
                  <a href="{{url('/serviceProvider/show/'.$user->id)}}" title="view " class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                  <a href="{{url('/serviceProvider/edit/'.$user->id)}}" title="edit " class="btn btn-bg" data-method="Edit" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-pencil"></i></a>
                  <a href="{{url('/serviceProvider/softDelete/'.$user->id)}}" onclick="return confirm('Are you sure to change its state ?')" title="delete" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
                
                  </td>
              </tr>
            @endforeach
            </tbody>
          </table>
          {{$provider->links()}}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


@push('styles')
<!-- Data Table CSS -->
<link rel="stylesheet" href="{{asset('public/dataTables/dataTables.min.css')}}">
@endpush

@push('scripts')
<!-- Data Table Script -->
<script src="{{asset('public/dataTables/dataTables.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            order: [
                [0, 'asc']
            ],
        });
    });
</script>

@endpush