@extends('admin.layouts.app')
@section('content')
<h2>Book Service</h2><br>
<div class="card">

    <form method="post" action="{{url('/booking/store')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="">
        <div class="row">
            <div class="col-lg-12">
            
            <div class="form-group">
                    <label>Select Service</label>
                    <select name="service_id" id="service_id" class="form-control">
                    <option value="">choose</option>
                        @foreach($service as $service)
                    <option value="{{$service->id}}">{{$service->name}}</option>
                         @endforeach 
                        {!!$errors->first("service_id", "<span class='text-danger'>:message</span>")!!}
                    </select>  
                </div>
                <div class="form-group" id="category">
  
                        {!!$errors->first("category_id", "<span class='text-danger'>:message</span>")!!}
                    </select>  
                </div>
                
                <div class="form-group"  id="subcategory">

                        {!!$errors->first("subcategory_id", "<span class='text-danger'>:message</span>")!!}
                    </select>             
                 </div>
                 <div class="form-group" >
                    <label>Add-on Service</label>             
                    <select name="addOn_id" id="addOn_id" class="form-control">
                        <option value="">choose</option>
                        @foreach($addOn as $addOn)
                        <option value="{{$addOn->id}}">{{$addOn->name}}</option>
                        @endforeach 
                    </select>  
                               
                 </div>
                 <div class="form-group">
                    <label>location:</label>
                    <input type="address" class="form-control" name="address" >
                    {!!$errors->first("address", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group">
                    <label>Date Of Service:</label>
                    <input type="date" class="form-control" name="date" >
                    {!!$errors->first("date", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group">
                    <label>Service Start Time</label>
                    <input type="time" class="form-control" name="time_start" >
                    {!!$errors->first("date", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group">
                    <label>Service End Time </label>
                    <input type="time" class="form-control" name="time_end" >
                    {!!$errors->first("date", "<span class='text-danger'>:message</span>")!!}
                </div>
        
                
            </div>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="submit">
        </div>
    </form>
</div>

@endsection
<script src="{{ url('/Modules/BookService/public/form.js') }}"></script>
<script src="{{ url('/Modules/BookService/public/book.js') }}"></script>
<script>
 var SITEURL = "{{url('/')}}";  
</script>