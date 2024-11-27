@extends('admin.layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h2>Add Custom Service</h2>
        </div>
        <div class="card-body">

    <form method="post" action="{{url('/booking/custom/store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Title:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value=""> 
            @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
        </div>
        <div class="form-group">
            <label>Description</label>
            <input type="text" class="form-control @error('desc') is-invalid @enderror" name="desc" value="">
             @error('desc')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
        </div>
         <div class="form-group">
            <label>Service Image</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
             @error('image')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="submit">
        </div>
    </form>
</div>
</div>
@endsection