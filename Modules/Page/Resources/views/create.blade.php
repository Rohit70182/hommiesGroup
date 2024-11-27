@extends('admin.layouts.app')

@section('template_title')
    Create Page
@endsection

@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Create Page</li>
    </ul>
</div>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')
                <div class="page-head-text">
                      <span class=" font_600 font-18 font-md-20 mr-auto pr-20">Create Page</span>
                </div>
                   
                <div class="card card-default">
                    
                    <div class="card-body">
                        <form method="POST" action="{{url('/page/save-page')}}"  role="form" enctype="multipart/form-data" id="create-page">
                            @csrf

                            <div class="box box-info padding-1">
                                <div class="box-body">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Title</label>
                                          <input type="text" class="form-control" name="title" value="{{old('title')}}">
                                          {!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label>Type</label>
                                          <select class="form-control" name="type_id" id="type_id">
                                              <option value="">Select type</option>
                                              @foreach(@$types as $key=>$type)
                                              <option value="{{ @$key }}" @if(old('type_id') == $key) selected='selected' @endif >{{ @$type }}</option>
                                              @endforeach
                                          </select>
                                          {!! $errors->first('type_id', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                      </div>
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          <label>Description</label>
                                          <textarea name="editor1">{{old('description')}}</textarea>
                                            {!! $errors->first('editor1', '<div class="invalid-feedback">The Description field is required.</div>') !!}
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="box-footer mt20">
                                    <button type="submit" class="btn btn-bg">Submit</button>
                                </div>
                            </div>


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
 jQuery('#create-page').validate({
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

@endpush
