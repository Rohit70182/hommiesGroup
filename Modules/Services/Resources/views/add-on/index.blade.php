@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Services</li>
    <li class="active">Add On Services</li>
  </ul>
</div>


<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
      <div class="page-head-text">
        <div class="ProfileHader d-flex flex-wrap align-items-center">
          <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Add On Services</h3>
           <a class="btn btn-bg" href="{{url('/services/add-on/add')}}">
              <i class="fa fa-plus"></i>
            </a>
        </div>
      </div>
       <div class="page-index">Index</div>
      <div class="card">
        <div class="card-header">


        </div>
        <div class="card-body table-responsive">
          <table id="datatable" class="table table-bordered project">
            <thead>
              <th>Id</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Service</th>
              <th>State</th>
              <th>Actions</th>


            </thead>
            <tbody>
              @foreach($add as $add)
              <tr>
                <td>{{$add->id}}</td>
                <td>{{$add->name}}</td>
                <td>{{$add->desc}}</td>
                <td>{{$add->price}}</td>
                <td>{{$add->getService ? $add->getService->name : '' }}</td>
                <td>{{$add->getState()}}</td>

                <td>
                  <a href="{{url('/services/add-on/view/'.$add->id)}}" title="view " class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                  <a href="{{url('/services/add-on/edit/'.$add->id)}}" title="edit" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>

                  <a href="{{url('/services/add-on/softDelete/'.$add->id)}}" onclick="return confirm('Are you sure to change its state ?')" title="change state" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
                </td>

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
<script type="text/javascript">
  $(document).ready(function() {
        $('#datatable').DataTable({
            order: [
                [0, 'DESC']
            ],
        });
    });


  jQuery(document).ready(function($) {
    jQuery('#addon-form').validate({
      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        name: {
          required: true,
        },
        desc: {
          required: true
        },
      },
      messages: {
        name: {
          required: "The title is required."
        },
        desc: {
          required: "The description is required."
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        jQuery(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        jQuery(element).removeClass('is-invalid');
      }
    });
  });
</script>

@endpush
