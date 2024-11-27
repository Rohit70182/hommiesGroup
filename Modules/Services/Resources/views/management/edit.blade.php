@extends('admin.layouts.app')
@section('content')
<?php
  //set headers to NOT cache a page
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<?php

use Modules\Services\Entities\Service;
?>

<div class="mb-3 mb-lg-4">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Update Service</li>
    </ul>
</div>

<div class="col-md-12">
    <div class="card">

        <form method="post" action="{{url('/services/update/'.$service->id)}}" enctype="multipart/form-data" id="add-service-form">
            @csrf
            <input type="hidden" name="id" value="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group mt-4	">
                        <label>Service Name</label>
                        <input type="text" class="form-control" name="name" value="{{$service->name}}">
                        {!!$errors->first("name", "<span class='text-danger'>enter category name </span>")!!}
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" row="4" name="desc">{{$service->desc}}</textarea>
                        {!!$errors->first("desc", "<span class='text-danger'>Enter description</span>")!!}
                    </div>
                    <div class="form-group">
                        <label>Select Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option select disabled>Choose</option>
                            @foreach($categoryData as $category)
                            <option value="{{$category->id}}" {{$category->id == $service->category_id ? 'selected' : '' }}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!--           Sub Cat ADD -->

                    <div class="form-group">
                        <label>Select Sub Category</label>
                        <select name="subcategory_id" id="subcategory_id" class="form-control">
                            <option select disabled>Choose</option>
                            @foreach($subCategory as $subcategory)
                            <option value="{{$subcategory->id}}" {{$subcategory->id == $service->subcategory_id ? 'selected' : '' }}>{{$subcategory->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!--           Sub Cat ADDED -->


                    
                    <div class="form-group">
                        <label>Status</label>
                        <select name="state_id" class="form-control">
                            <option value="{{Service::STATE_INCOMPLETE}}" {{$service->state_id == Service::STATE_INCOMPLETE ? 'selected' : ''}} select disabled >Select</option>
                            <option value="{{Service::STATE_ACTIVE}}" {{$service->state_id == Service::STATE_ACTIVE ? 'selected' : ''}}>Active</option>
                            <option value="{{Service::STATE_INACTIVE }}" {{$service->state_id == Service::STATE_INACTIVE ? 'selected' : ''}}>Inactive</option>
                        </select>
                        {!!$errors->first("status", "<span class='text-danger'>select status </span>")!!}
                    </div>
                    <div class="form-group">
                        <label>Image:</label>
                        <input type="file" class="form-control" name="image" >
                        {!!$errors->first("image", "<span class='text-danger'>:message</span>")!!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-bg" name="submit" value="Update">
            </div>
        </form>
    </div>
</div>


@endsection
<script src="{{ url('/Modules/Services/public/form.js') }}"></script>
<script src="{{ url('/Modules/Services/public/Services.js') }}"></script>
<script>
    var SITEURL = "{{url('/')}}";
</script>

@push('scripts')

<script type="text/javascript">
jQuery.noConflict();
jQuery( document ).ready(function( $ ) 
{


 jQuery('#add-service-form').validate({
      onkeyup: function(element) {
            jQuery(element).valid()
        },
      rules: 
      {
         name: {
            required: true, 
          }, 
         desc: {    
            required: true,
          },
         category_id: {     
            required: true,
          },
         subcategory_id: {
            required: true, 

          }, 
         price: {    
            min:1

          },
         type_id: {     
            required: true,
          },
          image: {
          extension: "jpeg|jpg|png"
        },
     },
    messages: {
      name: 
          {
            required: "The name is required."
          }, 
      desc: 
          {
            required: "The description is required."
          },
      category_id: 
          {
            required: "The category is required."
          },
      subcategory_id: 
          {
            required: "The subcategory is required."
          }, 
      type_id: 
          {
            required: "The status is required."
          },
      image: {
          extension: 'jpg, jpeg, png format allowed only'
          
        },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      jQuery(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      jQuery(element).removeClass('is-invalid');
    }
  });
  
  
});
</script>

@endpush
 