@extends('admin.layouts.app')
@section('content')
<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Update User</li>
  </ul>
</div>

<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
      <div class="page-head-text">
        <div class="ProfileHader d-flex flex-wrap align-items-center">
          <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Update User</h3>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
          <form method="post" action="{{url('dashboard/users/update/'.$GetData->id)}}" enctype="multipart/form-data" id="userUpdate-form">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-md-6 col-lg-6 col-12">
                <div class="form-group">
                  <label>Name:</label>
                  <input type="text" class="form-control" name="name" value="{{$GetData->name}}">
                  {!!$errors->first("name", "<span class='text-danger'>:message</span>")!!}
                </div>
              </div>
              <div class="col-md-6 col-lg-6 col-12">
                <div class="form-group">
                  <label>DOB:</label>
                  <input type="date" class="form-control" name="dob"  max="{{date('Y-m-d')}}" value="{{$GetData->dob}}">
                  {!!$errors->first("dob", "<span class='text-danger'>:message</span>")!!}
                </div>
              </div>
              <div class="col-md-6 col-lg-6 col-12">
                <div class="form-group">
                  <label>Address:</label>
                  <input type="text" class="form-control" name="address" value="{{$GetData->address}}">
                  {!!$errors->first("address", "<span class='text-danger'>:message</span>")!!}
                </div>
              </div>
              <div class="col-md-6 col-lg-6 col-12">
                <div class="form-group">
                  <label>Phone:</label>
                  <input type="text" class="form-control" name="phone" value="{{$GetData->phone}}">
                  {!!$errors->first("phone", "<span class='text-danger'>:message</span>")!!}
                </div>
              </div>
              <div class="col-md-6 col-lg-6 col-12">
                <div class="form-group">
                  <label>Email:</label>
                  <input type="email" class="form-control" name="email" value="{{ $GetData->email }}" disabled>
                  {!!$errors->first("email", "<span class='text-danger'>:message</span>")!!}
                </div>
              </div>
              <div class="col-md-6 col-lg-6 col-12">
                <div class="form-group">
                  <label>Profile file:</label>
                  <input type="file" class="form-control" name="image">
                  {!!$errors->first("image", "<span class='text-danger'>:message</span>")!!}
                </div>
              </div>
            </div>
            <div class="form-group text-right">
              <input type="submit" class="btn btn-bg" name="submit" value="Update">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@push('scripts')

<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
  
   $.validator.addMethod("alpha", function(value, element) 
    {
    	return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
	},'Enter letters only');
  
    jQuery('#userUpdate-form').validate({
      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        name: {
          required: true,
          alpha: true
        },
        dob: {
          required: true,
          
        },
        address: {
          required: true,
        },
         phone: {
          required: true,
           minlength: 10,
           maxlength: 15
        },
        image: {
          extension: "jpeg|jpg|png"
        },
      },
      messages: {
        name: {
          required: "The name is required.",
        },
        dob: {
          required: "The dob is required."
        },
        address: {
          required: "The address is required."
        },
        phone: {
          required: "The phone is required."
        },
        email: {
          required: "The email is required."
        },     
        image: {
          extension: 'jpg, jpeg, png format allowed only'
          
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