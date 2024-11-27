@extends('admin.layouts.app')
@section('content')
<div class="dash-home-cards">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Update Custom Service</h3>
          </div>
        </div>
        <div class="card-body">
    <form method="post" action="{{url('/booking/custom/update/'.$custom->id)}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Title:</label>
            <input type="text" class="form-control" name="name" value="{{$custom->name}}"> 
            {!!$errors->first("name", "<span class='text-danger'></span>")!!}
        </div>
        <div class="form-group">
            <label>Description</label>
            <input type="text" class="form-control" name="desc" value="{{$custom->desc}}">
            {!!$errors->first("desc", "<span class='text-danger'></span>")!!}
        </div>
         <div class="form-group">
            <label>Service Image</label>
            <input type="file" class="form-control" name="image" value="{{$custom->image}}">
            {!!$errors->first("image", "<span class='text-danger'>upload image</span>")!!}
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="submit">
        </div>
    </form>
</div>
</div>
</div>
</div>
</div>

@endsection