@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
    <li class="active">Add On Service</li>
  </ul>
</div>

<div class="col-md-12">
  <div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Add On Service</h3>
    </div>
  </div>
  <div class="card">
    <div class="card-header ">
<!--       <div class="float-left"> -->
<!--         <span class=" font_600 font-18 font-md-20 mr-auto pr-20">Add On Service</span> -->
<!--       </div> -->
    </div>
    <form method="post" action="{{url('/services/add-on/store')}}" id="addon-form" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name">
            {!!$errors->first("name", "<span class='text-danger'>Please enter a name</span>")!!}
          </div>
        </div>
        <div class="col-md-4">

          <div class="form-group">
            <label>Service</label>
            <select name='service_id' class="form-control">
              <option disabled selected>Choose a Service</option>
              @foreach($services as $service)
              <option value='{{ $service->id }}'>{{ $service->name }}</option>
              @endforeach()
            </select>
            {!!$errors->first("service_id", "<span class='text-danger'>Please select a service</span>")!!}
          </div>

        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Price</label>
            <input type="number" class="form-control" name="price">
            {!!$errors->first("price", "<span class='text-danger'>Please enter a valid price</span>")!!}
          </div>
        </div>
        <div class="col-lg-12">
          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="desc" rows="6"></textarea>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-bg mt-4 " name="submit" value="Submit">
          </div>

        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')

<script>
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
        price: {
          required: true,
          min:1
        },
        service_id: {
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
        price: {
          required: "The price is required.",
        },
        service_id: {
          required: "The service is required.",
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