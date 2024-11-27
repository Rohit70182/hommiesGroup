@extends('admin.layouts.app')
@section('content')
<?php

use Modules\ServiceProvider\Entities\ServiceProvider;
?>


<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Update Service Provider</li>
  </ul>
</div>

<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
      <div class="page-head-text">
        <div class="ProfileHader d-flex flex-wrap align-items-center">
          <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Update Service Provider</h3>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
          <form method="post" action="{{url('/serviceProvider/update/'.$provider->id)}}" enctype="multipart/form-data" id="serviceprovider-update">
            @csrf

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name:</label>
                  <input type="text" class="form-control" name="name" value="{{$provider->name}}">
                  {!!$errors->first("name", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Date Of Birth:</label>
                      <input type="date"  max="{{date('Y-m-d')}}"  class="form-control" name="dob" value="{{$provider->dob}}">
                      {!!$errors->first("dob", "<span class='text-danger'>:message</span>")!!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Gender</label>
                      <select name="gender" class="form-control">
                        <option value="">Choose</option>
                        <option value="1" {{$provider->gender == ServiceProvider::GENDER_MALE ? 'selected' : ''}}>Male</option>
                        <option value="2" {{$provider->gender == ServiceProvider::GENDER_FEMALE ? 'selected' : ''}}>Female</option>
                      </select>
                      {!!$errors->first("gender", "<span class='text-danger'>:message</span>")!!}
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label>Address:</label>
                  <input type="text" class="form-control" name="address" value="{{$provider->address}}">
                  {!!$errors->first("address", "<span class='text-danger'>:message</span>")!!}
                </div>

                <div class="form-group">
                  <label>Profile file:</label>
                  <input type="file" class="form-control" name="image">
                  <div>
                
                  </div>

                </div>
                
                
            <div class='form-group'>
            	<label>Services:</label>
            		<select name="services[]" id='select-service' class='select-service form-control' multiple="multiple">
                		<option disabled>Choose Services</option>
                		@foreach($services as $service)
                			<option value='{{ $service->id }}' {{ in_array($service->id,explode(',',$provider->services))? 'selected' : '' }}>{{ $service->name }}</option>
                		@endforeach
                	</select>
            </div>
            {!!$errors->first("services", "<span class='text-danger'>:message</span>")!!}
          
                
                <div class="form-group">
                  <input type="submit" class="btn btn-bg" name="submit" value="Update">
                </div>

              </div>
              <div class="col-md-6">


                <div class="form-group">
                  <label>Contact:</label>
                  <input type="number" class="form-control" name="phone" value="{{$provider->phone}}">
                  {!!$errors->first("phone", "<span class='text-danger'>:message</span>")!!}
                </div>

                <div class="form-group">
                  <label>Experience:</label>
                  <input type="number" class="form-control" name="experience" value="{{$provider->experience}}">
                  {!!$errors->first("experience", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Start time:</label>
                      <input type="time" class="form-control" name="start_time" id="start_time" value="{{date('H:i',strtotime($provider->start_time))}}">
                      {!!$errors->first("start_time", "<span class='text-danger'>:message</span>")!!}

                    </div>
                  </div>
                  <div class="col-md-6">

                    <div class="form-group">
                      <label>End time:</label>

                      <input type="time" class="form-control"  name="end_time" id="end_time" value="{{date('H:i',strtotime($provider->end_time))}}">

                      {!!$errors->first("end_time", "<span class='text-danger'>:message</span>")!!}

                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label>Certifications:</label>
                  <input type="file" class="form-control" name="certifications">
                  <div>
                  
                  </div>
                </div>


              </div>
            </div>



          </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@push('scripts')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $('#select-service').select2();
  jQuery.noConflict();
  jQuery(document).ready(function($) {
 	
 	$.validator.addMethod("greaterThan", 
    function(value, element, params) {
    	var startTime = $(params).val();
     	var endTime = value;
     	if(startTime >= endTime) {
     		return false;
     	} else {
     		return true;
     	}  	
    },'End Time must be greater than Start Time.');
    
    $.validator.addMethod("shorterThan", 
    function(value, element, params) {
    	var startTime = value;
     	var endTime = $(params).val();
     	if(startTime >= endTime) {
     		return false;
     	} else {
     		return true;
     	}  	
    },'Start Time must be shorter than End Time.');
	
   	$.validator.addMethod("alpha", function(value, element) 
    {
    	return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
	},'Enter letters only');
	
  
    jQuery('#serviceprovider-update').validate({
      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        name: {
          required: true,
          alpha: true
        },
        services: {
        	required: true,
        },
        dob: {
          required: true,
        },
        gender: {
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
        experience: {
          required: true,
          min:1
        },
        
        "services[]": {
        	required: true,
        },
        
        start_time: {
          required: true,
          shorterThan: '#end_time',
        },	
        
        end_time: {
          required: true,
          greaterThan: "#start_time",
        },
        datepicker: {
            required: true,
            date: true
        },
      },
      messages: {
        name: {
          required: "The name is required."
        },
        dob: {
          required: "The dob is required."
        },
        services: {
        	required: "Please select atleast one Service",
        },
        gender: {
          required: "The gender is required."
        },
        address: {
          required: "The address is required."
        },
        contact: {
          required: "The contact number is required."
        },
        experience: {
          required: "The experience is required."
        },
        start_time: {
          required: "The Start Time is required."
        },
        "services[]": {
        	required: 'Please select atleast one service',
        },
        end_time: {
          required: "The End Time is required."
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