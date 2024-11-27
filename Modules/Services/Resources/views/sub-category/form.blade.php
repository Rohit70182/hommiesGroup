@extends('admin.layouts.app')
@section('content')
<?php

use Modules\Seo\Entities\Seo;
?>

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Add Service Sub Category</li>
  </ul>
</div>

<div class="col-md-12">
  <div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Add Service Sub Category</h3>
    </div>
  </div>
  <div class="card">
    <div class="card-header ">
    </div>
    <form method="post" action="{{url('/services/sub-category/store')}}" enctype="multipart/form-data" id="subcategory-form">
      @csrf
      <input type="hidden" name="id" value="">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Sub-Category Title</label>
            <input type="text" class="form-control" name="name" value="{{old('name')}}">
            {!!$errors->first("name", "<span class='text-danger'>:message</span>")!!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control">
              <option disabled selected>Choose category</option>
              @foreach($category as $category)
              <option value="{{$category->id}}">{{$category->name}}</option>
              @endforeach
            </select>
            {!!$errors->first("category_id", "<span class='text-danger'>Select a Valid Category </span>")!!}
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="desc" rows="3">{{old('desc')}}</textarea>
            {!!$errors->first("desc", "<span class='text-danger'>Enter description</span>")!!}
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="Submit">
          </div>
        </div>
         <div class="col-lg-6">
                 <div class="form-group">
                    <label>Image:</label>
                    <input type="file" class="form-control" name="image" >
                    {!!$errors->first("image", "<span class='text-danger'>:message</span>")!!}
                </div>
        </div>
      </div>
    </form>
  </div>
</div>


@endsection


@push('scripts')

<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
    jQuery('#subcategory-form').validate({
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
        category_id: {
          required: true,
        },
        image: {
          required: true,
          extension: "jpeg|jpg|png"
        },
      },
      messages: {
        name: {
          required: "The title is required."
        },
        desc: {
          required: "The description is required."
        },
        category_id: {
          required: "The category is required."
        },
        image: {
          required: "The image is required.",
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