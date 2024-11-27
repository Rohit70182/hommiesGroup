<?php use App\Models\CancelReason; ?>
@extends('admin.layouts.app')
@section('content')
<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">Add Reason</li>
    </ul>
</div>
<div class="col-md-12">
<div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Add Reason</h3> 

    </div>
  </div>
    <div class="card">
    <div class="card-header ">
        <form method="post" action="{{route('storereason')}}" id="event-add-form" enctype="multipart/form-data">
       
            @csrf
            <div class="row mt-3 align-items-center">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Reason</label>
                        <textarea class="form-control" id="reason" rows="3" name="reason"></textarea>
                        {!!$errors->first("reason", "<span class='text-danger'>message</span>")!!}
                    </div>
                </div>
               
                
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="submit" class="btn btn-bg mt-4" name="submit"  id="submit"value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@push('scripts')
<script type="text/javascript">
 
    
jQuery( document ).ready(function( $ ) 
{
 jQuery('#event-add-form').validate({
      onkeyup: function(element) {
            jQuery(element).valid()
        },
      rules: {
     reason: {
        required: true, 
      }
     
    
      },
    messages: {
      reason: {
        required: "The Reason is required."
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
