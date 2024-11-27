@extends('admin.layouts.app')

@section('content')

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
     <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Update Page</li>
  </ul>
</div>


<section class="content container-fluid">
    <div class="">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class=" font_600 font-18 font-md-20 mr-auto pr-20">Update Page </span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('page.update', $page->id) }}" role="form" enctype="multipart/form-data" id="edit-page">
                        {{ method_field('PATCH') }}
                        @csrf

                        @include('page::form')

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
jQuery( document ).ready(function( $ ) 
{
 jQuery('#edit-page').validate({
      onkeyup: function(element) {
            jQuery(element).valid()
        },
      rules: 
      {
         title: {
            required: true, 
          }, 
        editor1: {    
            required: true,
          },
         type_id: {     
            required: true,
          },
     },
    messages: {
      title: 
          {
            required: "The title is required."
          }, 
       editor1: 
          {
            required: "The description is required."
          },
      type_id: 
          {
            required: "The type is required."
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


 <script>
CKEDITOR.replace( 'editor1' );
</script>

 <script>
  CKEDITOR.replace( 'editor1' );
 </script>
 @endpush