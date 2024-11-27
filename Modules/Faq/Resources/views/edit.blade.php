@extends('admin.layouts.app')

@section('content')
<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
    <li class="active">Update Faq</li>
  </ul>
</div>

<section class="content container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="page-head-text">
        <div class="ProfileHader d-flex flex-wrap align-items-center">
          <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Update Faq</h3>
        </div>
      </div>

      @includeif('partials.errors')

      <div class="card card-default">
        <div class="card-body">
          <form method="POST" action="{{ route('faq.update', $faq->id) }}" role="form" enctype="multipart/form-data" id="faq-form-edit">
            {{ method_field('PATCH') }}
            @csrf

            @include('faq::form')

          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')

<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
    jQuery('#faq-form-edit').validate({
      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        question: {
          required: true,
        },
        answer: {
          required: true
        },
      },
      messages: {
        question: {
          required: "The question is required."
        },
        answer: {
          required: "The answer is required."
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