@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Add Service Provider</li>
  </ul>
</div>

<div class="col-md-12">
  <div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Add Service Provider</h3>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
      <form method="post" action="{{url('/serviceProvider/store')}}" enctype="multipart/form-data" id="serviceprovider-add">
        @csrf
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Name:</label>
              <input type="text" class="form-control" name="name" value="{{old('name')}}">
              {!!$errors->first("name", "<span class='text-danger'>:message</span>")!!}
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Date Of Birth:</label>
                  <input type="date" max="{{date('Y-m-d')}}" class="form-control" name="dob" value="{{old('dob')}}">
                  {!!$errors->first("dob", "<span class='text-danger'>:message</span>")!!}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Gender</label>
                  <select name="gender" class="form-control">
                    <option value=""></option>
                    <option value="1" {{old('gender') == '1' ? 'selected' : ''}}>Male</option>
                    <option value="2" {{old('gender') == '2' ? 'selected' : ''}}>Female</option>
                  </select>
                  {!!$errors->first("gender", "<span class='text-danger'>:message</span>")!!}
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Address:</label>


              <input type="text" class="form-control" name="address" id="address" value="{{old('address')}}">
              <input type="hidden" class="form-control" name="latitude" id="latitude" value="{{old('latitude')}}">
              <input type="hidden" class="form-control" name="longitude" id="longitude" value="{{old('longitude')}}">

=
              

              {!!$errors->first("address", "<span class='text-danger'>:message</span>")!!}
            </div>

            <div class="form-group">
              <label>Profile Photo:</label>
              <input type="file" class="form-control" name="image">
              {!!$errors->first("image", "<span class='text-danger'>:message</span>")!!}
            </div>
            <div class='form-group'>
            	<label>Services:</label>
            	<select name="services[]" id='select-service' class='select-service form-control' multiple="multiple">
            		<option disabled>Choose Services</option>
            		@foreach($services as $service)
            			<option value='{{ $service->id }}'>{{ $service->name }}</option>
            		@endforeach
            	</select>
            	
            </div>
            {!!$errors->first("services", "<span class='text-danger'>:message</span>")!!}
 
          </div>
          
          <div class="col-md-6">
          <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" name="email" value="{{old('email')}}">
              {!!$errors->first("email", "<span class='text-danger'>:message</span>")!!}
            </div>
            <div class="form-group">
              <label>Contact Number:</label>
              <input type="number" class="form-control" name="phone" value="{{old('phone')}}">
              {!!$errors->first("phone", "<span class='text-danger'>:message</span>")!!}
            </div>
            <div class="form-group">
              <label>Experience:</label>
              <input type="number" class="form-control" name="experience" value="{{old('experience')}}">
              {!!$errors->first("experience", "<span class='text-danger'>:message</span>")!!}
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Start time:</label>
                  <input type="time" class="form-control" name="start_time" id="start_time" value="{{old('start_time')}}">
                  {!!$errors->first("start_time", "<span class='text-danger'>:message</span>")!!}

                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>End time:</label>
                  <input type="time" class="form-control"  name="end_time" id="end_time" value="{{old('end_time')}}">
                  {!!$errors->first("end_time", "<span class='text-danger'>:message</span>")!!}

                </div>
              </div>
            </div>
            
            <div class="form-group">
              <label>Certifications:</label>
              <input type="file" class="form-control" name="certifications">
              {!!$errors->first("certifications", "<span class='text-danger'>:message</span>")!!}
            </div>
			
          </div>
          
            <div class="form-group ml-3">
              <input type="submit" class="btn btn-bg" name="submit" value="Submit">
            </div>
        </div>
        </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?libraries=geometry,places&key=<?=env('GOOGLE_MAP_KEY')?>"></script>

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
	
  
    jQuery('#serviceprovider-add').validate({
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
        email:{
          required: true,
          email: true
        },
        image: {
          required: true,
          extension: "jpeg|jpg|png"
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
        certifications: {
          required: true,
          extension: "jpeg|jpg|png"
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
        image: {
          required: "The image is required.",
          extension: 'jpg, jpeg, png format allowed only'
        },
        phone: {
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
        certifications: {
          required: "The certifications is required.",
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
    
     var autocomplete = new google.maps.places.Autocomplete($("#address")[0], {});

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
    var place = autocomplete.getPlace();
    $('#latitude').val(place.geometry.location.lat());
    $('#longitude').val(place.geometry.location.lng());


    var address_components = place.address_components;

    $.each(address_components, function(index, component){
      var types = component.types;
      $.each(types, function(index, type){
        if(type == 'locality') {
          city = component.long_name;
          $('#city').val(city);
        }
        if(type == 'postal_code') {
          postal_code = component.long_name;
          $('#zipcode').val(postal_code);
        }
        if(type == 'country') {
          country = component.long_name;
          $('#country').val(country);

        }
      });
    });
   });


    
  });
</script>

<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=PUT_GOOGLE_API_KEY&libraries=places"></script>
 
<script>
google.maps.event.addDomListener(window, 'load', initialize);
function initialize() {
var input = document.getElementByName('address');
var autocomplete = new google.maps.places.Autocomplete(input);
autocomplete.addListener('place_changed', function () {
var place = autocomplete.getPlace();
// place variable will have all the information you are looking for.
 
  document.getElementByName("latitude").value = place.geometry['location'].lat();
  document.getElementByName("longitude").value = place.geometry['location'].lng();
});
}
</script> -->
@endpush