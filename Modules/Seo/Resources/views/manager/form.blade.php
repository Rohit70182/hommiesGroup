@extends('admin.layouts.app')
@section('content')
<?php

use Modules\Seo\Entities\Seo;
?>

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Seo Manager</li>
    <li class="active">Meta</li>
    <li class="active">{{ isset($seo) ? 'Update' : 'Add' }}</li>
  </ul>
</div>

<!-- <h2 class="ml-3 mt-3">{{ isset($seo) ? 'Update' : 'Add' }}</h2><br> -->

  <div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">{{ isset($seo) ? 'Update' : 'Add' }}</h3>
  	</div>
  </div>

<div class="card">
    <form method="post" action="{{url('/seo/manager/store')}}" enctype="multipart/form-data" id="add-seo-form">
        @csrf
        <input type="hidden" name="id" value="{{ isset($seo) ? $seo->id : '' }}">
        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" value="{{ isset($seo) ? $seo->title : '' }}" required>
                    {!!$errors->first("title", "<span class='text-danger'>Title is required</span>")!!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Route</label>
                    <input type="text" class="form-control" name="route" value="{{ isset($seo) ? $seo->route : '' }}" required>
                    {!!$errors->first("route", "<span class='text-danger'>Route is required</span>")!!}
                </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                    <label>Keyword</label>
                    <input type="text" class="form-control" name="keywords" value="{{ isset($seo) ? $seo->keywords : '' }}" required>
                    {!!$errors->first("keywords", "<span class='text-danger'>Keyword is required</span>")!!}
                </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                    <label>Data</label>
                    <input type="text" class="form-control" name="data" value="{{ isset($seo) ? $seo->data : '' }}" required>
                    {!!$errors->first("data", "<span class='text-danger'>Data is required</span>")!!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option selected disabled>Select</option>
                        <option value="1" {{ isset($seo) && $seo->state_id == Seo::STATE_ACTIVE ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ isset($seo) && $seo->state_id == Seo::STATE_INACTIVE ? 'selected' : '' }}>Inactive</option>
                        
                    </select>
                    {!!$errors->first("status", "<span class='text-danger'>Status is required</span>")!!}
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="description" rows="6" required>{{ isset($seo) ? $seo->description : '' }}</textarea>
                    {!!$errors->first("description", "<span class='text-danger'>Description is required</span>")!!}
                </div>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="Submit">
        </div>
    </form>
</div>
@endsection

@push('scripts')

<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
  
    jQuery('#add-seo-form').validate({
      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        title: {
          required: true,
        },
        description: {
          required: true,
        },
        route: {
          required: true,
        },
        keywords: {
          required: true,
        },
        data: {
          required: true,
        },
        status: {
          required: true,
        },
      },
      messages: {
        title: {
          required: "The title is required."
        },
        description: {
          required: "The description is required."
        },
        route: {
          required: "The route is required."
        },
        keywords: {
          required: "The keyword is required."
        },
        data: {
          required: "The data is required."
        },
        status: {
          required: "The status is required."
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

