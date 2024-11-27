@extends('admin.layouts.app')
@section('content')


<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">Add Event</li>
    </ul>
</div>
<div class="col-md-12">
<div class="page-head-text">
    <div class="ProfileHader d-flex flex-wrap align-items-center">
      <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Add Event</h3>
    </div>
  </div>
    <div class="card">
    <div class="card-header ">
        <form method="post" action="{{url('/event/store')}}" id="event-add-form" enctype="multipart/form-data">
            @csrf
            <div class="row mt-3 align-items-center">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="">
                        {!!$errors->first("title", "<span class='text-danger'>message</span>")!!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="desc" rows="6" ></textarea>
                        {!!$errors->first("desc", "<span class='text-danger'>message</span>")!!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Select Service</label>
                        <select name="service_id[]" id="service_id" class="select2 form-control" multiple="multiple">
                            @foreach($services as $service)
                            <option value={{$service->id}}>{{$service->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" name="price" value="">
                        {!!$errors->first("price", "<span class='text-danger'>message</span>")!!}
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="submit" class="btn btn-bg mt-4" name="submit" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

</div>

@endsection
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
    
    
jQuery( document ).ready(function( $ ) 
{
 jQuery('#event-add-form').validate({
      onkeyup: function(element) {
            jQuery(element).valid()
        },
      rules: {
     title: {
        required: true, 
      }, 
     "service_id[]": {    
        required: true,
        minlength: 2
      },
      
     price: {    
        required: true,
        min:1
      },
       desc: {    
        required: true
      },
      },
    messages: {
      title: {
        required: "The title is required."
      }, 
      "service_id[]": {
        required: "The service is required.",
        minlength: 'Please select atleast 2 services'
      },
      price: {
        required: "The price is required."
      },
       desc: {    
        required: "The description is required."
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