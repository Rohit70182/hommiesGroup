@extends('admin.layouts.app')
@section('content')
<?php

use Modules\Services\Entities\Coupon;
?>


<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Update Coupon</li>
  </ul>
</div>

<div class="col-md-12">
  <div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Update Coupon
    </div>

  </div>
  <div class="card">
  <div class="card-header ">
    <form method="post" action="{{url('/services/coupon/update/'.$coupon->id)}}" enctype="multipart/form-data" id="coupon-edit-form">
      @csrf
      <input type="hidden" name="id" value="">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group mt-3">
            <label>Title</label>
            <input type="text" class="form-control" name="name" value="{{$coupon->name}}">
            {!!$errors->first("name", "<span class='text-danger'>:message</span>")!!}
          </div>

        </div>
        <div class="col-md-6">
          <div class="form-group mt-3"">
                        <label>Description</label>
                        <input type=" text" class="form-control" name="desc" value="{{$coupon->desc}}">
            {!!$errors->first("desc", "<span class='text-danger'>description is required</span>")!!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Amount</label>
            <input type="number" class="form-control" name="amount" value="{{$coupon->amount}}">
            {!!$errors->first("amount", "<span class='text-danger'>Enter a valid amount</span>")!!}
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>State</label>
            <select name="state_id" class="form-control">
              <option select disabled>Select</option>
              <option value="0" {{$coupon->state_id == Coupon::STATE_INACTIVE ? 'selected' : ''}}>Inactive</option>
              <option value="1" {{$coupon->state_id == Coupon::STATE_ACTIVE ? 'selected' : ''}}>Active</option>
            </select>
            {!!$errors->first("state_id", "<span class='text-danger'>Select a Valid state</span>")!!}
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="Update">
          </div>
        </div>
      </div>
    </form>
  </div>
  
</div>

</div>

@endsection

@push('scripts')

<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
    jQuery('#coupon-edit-form').validate({
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
        amount: {
          required: true,
          min:1
        },
        state_id: {
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
        amount: {
          required: "The amount is required."
        },
        state_id: {
          required: "The state is required."
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