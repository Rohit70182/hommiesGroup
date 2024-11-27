@extends('admin.layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h2> Schedule Service</h2>
        </div>
        <div class="card-body">

    <form method="post" action="{{url('/booking/schedule/store')}}" enctype="multipart/form-data">
        @csrf
      
        <div class="form-group">
                    <label>Select Service</label>
                    <select name="service_id" id="service_id" class="form-control" value ="">
                    <option value="">Choose</option>
                    @foreach($service as $service)
                   <option value="{{$service->id}}">{{$service->name}}</option>
                   @endforeach
                    </select>  
                </div>
                
                 <div class="form-group"  id="subcategory">
                    <label> Select Service Provider</label>             
                    <select name="provider_id" id="addOn_id" class="form-control" >
                        <option value="">Choose</option>
                        @foreach($provider as $provider)
                        <option value="{{$provider->id}}">{{$provider->name}}</option>
                        @endforeach
                    </select>             
                 </div>
                 <div class="form-group">
                    <label>location:</label>
                    <input type="address" class="form-control" name="address"  value="">
                    {!!$errors->first("address", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group">
                    <label>Date Of Service:</label>
                    <input type="date" class="form-control" name="date" value="" >
                    {!!$errors->first("date", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group">
                    <label>Service Start Time</label>
                    <input type="time" class="form-control" name="time_start"  value="">
                    {!!$errors->first("date", "<span class='text-danger'>:message</span>")!!}
                </div>
                <div class="form-group">
                    <label>Service End Time </label>
                    <input type="time" class="form-control" name="time_end"  value="">
                    {!!$errors->first("date", "<span class='text-danger'>:message</span>")!!}
                </div>
 

        <div class="form-group">
            <input type="submit" class="btn btn-bg" name="submit" value="submit">
        </div>
    </form>
</div>
</div>
@endsection