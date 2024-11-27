@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">Book New Service</li>
    </ul>
</div>
<div class="col-md-12">
    <div class="card">

        <form method="post" action="{{url('/services/booking-req/store')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="">
            <div class="row">
                <div class="col-lg-12">

                    <div class="form-group">
                        <label>Select Service</label>
                        <select name="service_id" id="service_id" class="form-control">
                            <option value="">choose</option>
                            @foreach($service as $services)
                            <option value="{{$services->id}}">{{$services->name}}</option>
                            @endforeach

                        </select>
                        {!!$errors->first("service_id", "<span class='text-danger'>:message</span>")!!}
                    </div>

                    <div class="form-group">
                        <label>Add-on Service</label>
                        <select name="addOn_id" id="addOn_id" class="form-control">
                            <option value="">choose</option>
                            @foreach($addOn as $addOns)
                            <option value="{{$addOns->id}}">{{$addOns->name}}</option>
                            @endforeach
                        </select>
                        {!!$errors->first("service_id", "<span class='text-danger'>:message</span>")!!}
                    </div>
                    <div class="form-group">
                        <label>location:</label>
                        <input type="address" class="form-control" name="address">
                        {!!$errors->first("address", "<span class='text-danger'>:message</span>")!!}
                    </div>
                    <div class="form-group">
                        <label>Date Of Service:</label>
                        <input type="date" class="form-control" name="date">
                        {!!$errors->first("date", "<span class='text-danger'>:message</span>")!!}
                    </div>
                    <div class="form-group">
                        <label>Service Start Time</label>
                        <input type="time" class="form-control" name="time_start">
                        {!!$errors->first("date", "<span class='text-danger'>:message</span>")!!}
                    </div>
                    <div class="form-group">
                        <label>Service End Time </label>
                        <input type="time" class="form-control" name="time_end">
                        {!!$errors->first("date", "<span class='text-danger'>:message</span>")!!}
                    </div>


                </div>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-bg" name="submit" value="submit">
            </div>
        </form>
    </div>
</div>
@endsection