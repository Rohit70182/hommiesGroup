@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Update Event</li>
    </ul>
</div>
<div class="col-md-12">

    <div class="card">
        <form method="post" action="{{url('update/'.$events->id)}}" enctype="multipart/form-data" id="event-edit-form">
            @csrf
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group mt-3">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $events->title}}">
 						{!!$errors->first("title", "<span class='text-danger'>:message</span>")!!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Select Service</label>
                        <select name="service_id[]" id="service_id" class="select2 form-control" multiple="multiple">
                            @foreach($services as $service)
                            <option value="{{$service->id}}" {{ in_array($service->id, explode(',',$events->services)) ? 'selected' : '' }}>{{$service->name}}</option>
                            @endforeach
                        </select>
						 {!!$errors->first("service_id", "<span class='text-danger'>:message</span>")!!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" name="price" value="{{$events->price}}">
                        {!!$errors->first("price", "<span class='text-danger'>message</span>")!!}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group  mt-3">
                        <label>Description</label>
                        <textarea class="form-control" name="desc" rows="6">{{$events->desc}}</textarea>
                        {!!$errors->first("desc", "<span class='text-danger'>Enter category description</span>")!!}
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


@endsection
@push('scripts')

<link href="{{asset('/public/assets/css/select2.min.css')}}" rel="stylesheet" />
<script src="{{asset('/public/assets/js/select2.min.js')}}"></script>	
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    })


jQuery( document ).ready(function( $ ) 
{
 jQuery('#event-edit-form').validate({
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
