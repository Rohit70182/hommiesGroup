@extends('admin.layouts.app')
@section('content')
<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">Update Profile</li>
    </ul>
</div>

<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
            <div class="page-head-text">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20  pr-20">Update Profile</h3> <span class="badge badge-success">Active</span>
          </div>
        </div>
        <div class="page-index">
            Update Profile
        </div>
      <div class="card pt-3">

        <div class="card-body">

          <form action="{{ url('dashboard/myprofile/update/'.$GetUser->id) }}" method="POST" enctype="multipart/form-data" id="personaldetails-add">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="form-group mb-3">
                  <label for="">Name</label>
                  <input type="text" name="name" value="{{ old( 'name', $GetUser->name) }}" required class="form-control">
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="form-group mb-3">
                  <label for="">Phone</label>
                  <input type="number" name="phone" required value="{{$GetUser->phone}}" class="form-control">
                  @error('phone')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              
              <div class="col-md-6 col-12">
                <div class="form-group mb-3">
                  <label for="">Email</label>
                  <input type="text" name="email" value="{{ old( 'email', $GetUser->email) }}" required class="form-control" disabled>
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              
              <div class="col-md-6 col-12">
                <div class="form-group">
                  <label>Profile File:</label>
                  <input type="file" class="form-control" name="image">
					@error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
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
@push('styles')

@endpush


@push('scripts')

<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
  
    $.validator.addMethod("alpha", function(value, element) 
    {
    	return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
	},'Enter letters only');
    
    jQuery('#personaldetails-add').validate({
    

      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        name: {
          required: true,
          alpha	:true
        },
        phone: {
          required: true,
           minlength: 10,
           maxlength: 15
        },
      },
      messages: {
        name: {
          required: "The name is required.",
        },
        phone: {
          required: "The phone is required.",
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
