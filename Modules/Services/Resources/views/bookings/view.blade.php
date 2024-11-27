@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">View Booking Request</li>
    </ul>
</div>

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
        
        <div class="page-head-text">
                <div class="ProfileHader d-flex flex-wrap align-items-center">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">View Booking Request</h3>
                      <div class="float-right">
                     		<a href="{{url('/services/booking-req/remove/'.$bookings->id)}}" onclick="return confirm('Are you sure to delete this custom request ?')" title="delete" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>

            			<a class="btn btn-bg" href="{{url('/services/booking-req')}}"> Back</a>

    				</div>
                </div>
            </div>
        
            <div class="card">
               
                <div class="card-body col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="analytics-detail-view" class="table table-striped table-bordered detail-view">
                                            <tbody>
                                                <tr>
                                                    <th>Service</th>
                                                    <td colspan="1">{{$bookings->service_id ? $bookings->getService->name: ''}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Add-On</th>
                                                    <td colspan="1">{{$bookings->addOn_id ? $bookings->getAddOn->name: ''}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Date</th>
                                                    <td colspan="1">{{$bookings->date}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Start Time</th>
                                                    <td colspan="1">{{$bookings->time_start}}</td>
                                                </tr>
                                                <tr>
                                                    <th>End Time</th>
                                                    <td colspan="1">{{$bookings->time_end}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>Address</th>
                                                    <td colspan="1">{{$bookings->address}}</td>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection