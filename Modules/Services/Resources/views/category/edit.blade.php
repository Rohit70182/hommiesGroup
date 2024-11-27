@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Update Category</li>
  </ul>
</div>

<div class="col-md-12">
  <div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Update Category</h3>
    </div>
  </div>

  <div class="card">

    <form method="post" action="{{url('/services/category/update/'.$category->id)}}" enctype="multipart/form-data" id="category-edit-form">
      @csrf
      <input type="hidden" name="id" value="">
      <div class="row">
        <div class="col-lg-12">
          <div class="form-group mt-3">
            <label>Category Name</label>
            <input type="text" class="form-control" name="name" value="{{$category->name}}">
            {!!$errors->first("name", "<span class='text-danger'>:message </span>")!!}
          </div>

          <div class="form-group">
            <label>Description</label>
            <input type="textarea" class="form-control" name="desc" value="{{$category->desc}}">
            {!!$errors->first("desc", "<span class='text-danger'>enter category description</span>")!!}
          </div>
          <div class="form-group">
            <label>Image:</label>
            <input type="file" class="form-control" name="image">
            {!!$errors->first("image", "<span class='text-danger'>:message</span>")!!}
          </div>
          <!-- <div class="form-group">
                    <label>Status</label>
                    <select name="type_id" class="form-control" required>
                        <option>Select</option>
                        <option value="0" {{ isset($analytics) && $analytics->type_id == "0" ? 'selected' : '' }}>Google Analytics</option>
                    </select>
                    {!!$errors->first("status", "<span class='text-danger'>message</span>")!!}
                </div> -->
        </div>
      </div>

      <div class="form-group">
        <input type="submit" class="btn btn-bg" name="submit" value="Update">
      </div>
    </form>
  </div>
</div>


@endsection

@push('scripts')

<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function($) {
  
    jQuery('#category-edit-form').validate({
      onkeyup: function(element) {
        jQuery(element).valid()
      },
      rules: {
        name: {
          required: true,
        },
        desc: {
          required: true,
        },
         image: {
          extension: "jpeg|jpg|png"
        },
      },
      messages: {
        name: {
          required: "The name is required."
        },
        desc: {
          required: "The description is required."
        },
         image: {
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