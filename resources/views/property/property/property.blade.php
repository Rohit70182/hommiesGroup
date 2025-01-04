@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Properties</li>
  </ul>
</div>


<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
      <div class="page-head-text">
        <div class="ProfileHader d-flex flex-wrap align-items-center">
          <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Properties</h3>
          <!--             <a class="btn btn-bg" href="{{ url('/dashboard/user/add') }}"> -->
          <!--               <i class="fa fa-plus mr-1"></i>Add User -->
          <!--             </a> -->
        </div>
      </div>
      <div class="page-index">Index</div>
      <div class="card">


        <div class="card-body table-responsive">
          <table id="datatable" class="table table-bordered project">
            <thead>
              <th>Id</th>
              <th>Property Name</th>
              <th>Price</th>
              <th>Property Type</th>
              <th>Status</th>
              <th>Rating</th>
              <th>Sold To</th>
              <th>Platform Sold</th>
              <th>Created by</th>
              <th>Created On</th>
              <th>Actions</th>
            </thead>
            <tbody>
              @foreach($properties as $property)
              <tr>
                <td>{{ $property->id }}</td>
                <td>{{ $property->name }}</td>
                <td class="text-primary">{{ $property->price ? '$' . number_format($property->price, 2) : '-' }}</td>
                <td class="text-primary">{{ $property->getType() }}</td>
                <td>{{$property->getState()}}</td>
                <td>{{$property->rating ? $property->rating : '-'}}</td>
                <td>{{$property->soldTo ? $property->soldTo->name : '-'}}</td>
                <td>
                  @if($property->histories->isEmpty())
                  -
                  @else
                  {{ $property->histories->first()->getSold() }}
                  @endif
                </td>

                <td> {{$property->user ? $property->user->name : '-'}}</td>
                <td><label class="label label-info">{{ DateFormat($property->created_at) }}</label></td>
                <td>
                  <a href="{{url('/dashboard/property/show/'.$property->id)}}" title="view" class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                  <a href="{{url('dashboard/property/softDelete/'.$property->id)}}" onclick="return confirm('Are you sure to change its state ?')" title="change state" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
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
        [0, 'DESC']
      ],
    });
  });
</script>

@endpush