@extends('admin.layouts.app')
@section('content')
<h2>Update Booking</h2><br>
<div class="card">

    <form method="post" action="{{url('/booking/update/'.$bookings->id)}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="">
        <div class="row">
            <div class="col-lg-12">
            <div class="form-group">
                    <label>Select Service</label>
                    <select name="service_id" id="service_id" class="form-control" value ="">
                    <option>{{$bookings->service_id}}</option>
                        <option value="1">Service 1</option>
                        <option value="2">Service 2</option>
                    </select>  
                </div>
                <div class="form-group">
                    <label>Select Category</label>
                    <select name="category_id" id="category_id" class="form-control" value="">
                    <option>{{$bookings->category_id}}</option>
                        
                        <option value="1">Service-Category-1</option>
                        <option value="2">Service-Category-2</option>
                        <option value="3">Service-Category-3</option>
                    </select>  
                </div>
                
                <div class="form-group"  id="subcategory">
                    <label>Select Sub-Category</label>             
                    <select name="subcategory_id" id="sub_category_id" class="form-control" >
                        <option>{{$bookings->subcategory_id}}</option>
                        <option value="1">Sub-Category 1</option>
                        <option value="2">Sub-Category 2</option>
                        <option value="3">Sub-Category 3</option>
                        
                    </select>             
                 </div>
                 <div class="form-group"  id="subcategory">
                    <label>Add-on Service</label>             
                    <select name="addOn_id" id="addOn_id" class="form-control" >
                        <option value="{{$bookings->addOn_id}}"></option>
        
                        <option value="1">Add on 1</option>
                        <option value="2">Add on 2</option>
                        
                    </select>             
                 </div>
                 <div class="form-group">
                    <label>location:</label>
                    <input type="address" class="form-control" name="address"  value="{{$bookings->address}}">
                    {!!$errors->first("address", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group">
                    <label>Date Of Service:</label>
                    <input type="datetime" class="form-control" name="date" value="{{$bookings->date}}" >
                    {!!$errors->first("date", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group">
                    <label>Service Start Time</label>
                    <input type="time" class="form-control" name="time_start"  value="{{$bookings->time_start}}">
                    {!!$errors->first("date", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group">
                    <label>Service End Time </label>
                    <input type="time" class="form-control" name="time_end"  value="{{$bookings->time_end}}">
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