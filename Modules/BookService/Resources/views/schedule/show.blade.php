@extends('admin.layouts.app')
@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                    <div class="float-left">
                        <span class=" font_600 font-18 font-md-20 mr-auto pr-20"> Scheduled-Service</span>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-bg" href="{{url('/booking/schedule')}}" title="Manage"><span class="fa fa-list"></span></a>
                        <a class="btn btn-bg" href="{{url('/booking/schedule/edit/'.$schedule->id)}}" title="Update"><span class="fa fa-pencil"></span></a>
                    </div>
                </div>
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
                                                    <td colspan="1">{{$schedule->service_id}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>Service Provider</th>
                                                    <td colspan="1">{{$schedule->provider_id}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Date</th>
                                                    <td colspan="1">{{$schedule->date}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Start Time</th>
                                                    <td colspan="1">{{$schedule->start_time}}</td>
                                                </tr>
                                                <tr>
                                                    <th>End Time</th>
                                                    <td colspan="1">{{$schedule->end_time}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>Address</th>
                                                    <td colspan="1">{{$schedule->address}}</td>
                                                    
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