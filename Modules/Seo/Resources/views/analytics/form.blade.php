@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Seo Manager</li>
    <li class="active">Analytics</li>
    <li class="active">{{ isset($seo) ? 'Update' : 'Add' }}</li>
  </ul>
</div>

<div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">{{ isset($analytics) ? 'Update' : 'Add' }}</h3>
  	</div>
  </div>

<!-- <h2>{{ isset($analytics) ? 'Update' : 'Add' }}</h2><br> -->

<div class="card">

    <form method="post" action="{{url('/seo/analytics/store')}}" enctype="multipart/form-data" id="add-analytics-form">
        @csrf
        <input type="hidden" name="id" value="{{ isset($analytics) ? $analytics->id : '' }}">
        <div class="row mt-3">
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Account</label>
                    <input type="text" class="form-control" name="account" value="{{ isset($analytics) ? $analytics->account : '' }}" required>
                    {!!$errors->first("account", "<span class='text-danger'>Account is required</span>")!!}
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Domain Name</label>
                    <input type="text" class="form-control" name="domain_name" value="{{ isset($analytics) ? $analytics->domain_name : '' }}" required>
                    {!!$errors->first("domain_name", "<span class='text-danger'>Domain name is required</span>")!!}
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                    <label>Analytics Type</label>
                    <select name="type_id" class="form-control" required>
                        <option selected disabled>Select</option>
                        <option value="0" {{ isset($analytics) && $analytics->type_id == "0" ? 'selected' : '' }}>Google Analytics</option>
                    </select>
                    {!!$errors->first("type_id", "<span class='text-danger'>Analytics type is required</span>")!!}
                </div>
              </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="submit">
        </div>
    </form>
</div>

@endsection

@push('scripts')

<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
  
    jQuery('#add-analytics-form').validate({
      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        account: {
          required: true,
        },
        domain_name: {
          required: true,
        },
        type_id: {
          required: true,
        },
      },
      messages: {
        account: {
          required: "The title is required."
        },
        domain_name: {
          required: "The description is required."
        },
        type_id: {
          required: "The route is required."
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

