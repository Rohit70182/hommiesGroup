@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Amenities</li>
  </ul>
</div>
<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
      <div class="page-head-text">
        <div class="ProfileHader d-flex flex-wrap align-items-center">
          <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Amenities</h3>
        </div>
      </div>
      <div class="page-index">Index</div>
      <div class="card">
        <div class="card-body table-responsive">
          <table id="datatable" class="table table-bordered project">
            <thead>
              <th>Id</th>
              <th>Name</th>
              <th>Image</th>
              <th>State</th>
              <th>Created By</th>
              <th>Created On</th>
              <th>Actions</th>
            </thead>
            <tbody>
              @foreach($amenities as $amenity)
              <tr>
                <td>{{ $amenity->id }}</td>
                <td>{{ $amenity->name ? $amenity->name : '-'}}</td>
                <td class="text-primary"><img src="{{ $amenity->getAmanitiesImageAttribute() }}" alt="img"></td>
                <td> {{$amenity->getState()}}</td>
                <td> {{$amenity->user ? $amenity->user->name : '-'}}</td>
                <td><label class="label label-info">{{ DateFormat($amenity->created_at) }}</label></td>
                <td>
                  <a href="{{url('/dashboard/amenity/show/'.$amenity->id)}}" title="view" class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                  <a href="{{url('dashboard/amenity/softDelete/'.$amenity->id)}}" onclick="return confirm('Are you sure to change its state ?')" title="change state" class=" btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-trash"></i></a>
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