@extends('admin.layouts.app')
@section('content')
<?php

use Modules\Services\Entities\Service;
?>
<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">Log</li>
    </ul>
</div>

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="page-head-text">
                <div class="ProfileHader d-flex flex-wrap align-items-center">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Log</h3>
                    
                    <div class="float-right">
                        <a class="btn btn-bg" href="{{url('/logActivity')}}"> Back</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header ">
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
                                                    <th>Serial</th>
                                                    <td colspan="1">{{$logs->id}}</td>
                                                </tr>
                                                <tr>
                                                    <th>URL</th>
                                                    <td colspan="1">{{$logs->url}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Method</th>
                                                    <td colspan="1">{{ $logs->method }}</td>
                                                </tr>
                                                <tr>
                                                    <th>User Ip</th>
                                                    <td colspan="1">{{ $logs->ip }}</td>
                                                </tr>
                                                <tr>
                                                    <th>User Agent</th>
                                                    <td colspan="1">{{ $logs->agent }}</td>
                                                </tr>
                                                <tr>
                                                    <th>User Id</th>
                                                    <td colspan="1">{{ $logs->user_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Time</th>
                                                    <td colspan="1">{{ $logs->created_at}}</td>
                                                </tr>
                                                <!--                                                 <tr> -->
                                                <!--                                                     <th>Action</th> -->
                                                <!--                                                     <td colspan="1"> </td> -->
                                                <!--                                                 </tr> -->
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