@extends('admin.layouts.app')
@section('content')


<div class="mb-1 mt-2">
  <ul class="breadcrumb">
    <li><a href="{{url('/dashboard')}}">Home</a></li>
    <li class="active">Update Sub Category</li>
  </ul>
</div>

<div class="col-md-12">
  <div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Update Sub Category</h3>
    </div>
  </div>
  <div class="card">
    <div class="card-header ">
      
    </div>
    <form method="post" action="{{url('/services/sub-category/update/'.$subcategory->id)}}" enctype="multipart/form-data" id="subcategory-edit-form">
      @csrf
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Sub-Category Title</label>
            <input type="text" class="form-control" name="name" value="{{$subcategory->name}}">
            {!!$errors->first("name", "<span class='text-danger'>:message</span>")!!}
          </div>
        </div>
        <div class="col-md-6">

          <div class="form-group">
            <label>Description</label>
            <input type="text" name="desc" class="form-control" value="{{$subcategory->desc}}"></input>
            {!!$errors->first("desc", "<span class='text-danger'>enter description</span>")!!}
          </div>
        </div>
        <div class="col-md-6">
		<div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control">
              <option disabled selected>Choose category</option>
              @foreach($category as $category)
              <option value="{{$category->id}}" {{$category->id == $subcategory->category_id ? 'selected' : ''}}>{{$category->name}}</option>
              @endforeach
            </select>
            {!!$errors->first("category_id", "<span class='text-danger'>Select a valid Category </span>")!!}
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="Update">
          </div>
        </div>
        
        <div class="col-md-6">

          <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control" value="{{$subcategory->image}}"></input>
            {!!$errors->first("image", "<span class='text-danger'>enter description</span>")!!}
          </div>
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
    jQuery('#subcategory-edit-form').validate({
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
          extension: "jpeg|jpg|png",
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
          extension: "jpg, jpeg, png format allowed only"
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