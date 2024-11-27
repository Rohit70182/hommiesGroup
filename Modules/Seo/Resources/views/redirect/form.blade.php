@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Seo Manager</li>
    <li class="active">Redirect</li>
    <li class="active">{{ isset($seo) ? 'Update' : 'Add' }}</li>
  </ul>
</div>

  <div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">{{ isset($redirect) ? 'Update' : 'Add' }}</h3>
  	</div>
  </div>

<!-- <h2>{{ isset($redirect) ? 'Update' : 'Add' }}</h2><br> -->
<div class="card">

    <form method="post" action="{{url('/seo/redirect/store')}}" enctype="multipart/form-data" id="add-redirect-form">
        @csrf
        <input type="hidden" name="id" value="{{ isset($redirect) ? $redirect->id : '' }}">
        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Old url</label>
                    <input type="text" class="form-control" name="old_url" value="{{ isset($redirect) ? $redirect->old_url : '' }}" >
                    {!!$errors->first("old_url", "<span class='text-danger'>Old url is required</span>")!!}

                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>New url</label>
                    <input type="text" class="form-control" name="new_url" value="{{ isset($redirect) ? $redirect->new_url : '' }}" >
                    {!!$errors->first("new_url", "<span class='text-danger'>New url is required</span>")!!}
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
  
    jQuery('#add-redirect-form').validate({
      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        old_url: {
          required: true,
          url: true,
        },
        new_url: {
          required: true,
          url: true,
        },
      },
      messages: {
        old_url: {
          required: "The old url is required.",
          url: "Please enter a valid URL."
        },
        new_url: {
          required: "The new url is required.",
          url: "Please enter a valid URL."
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

