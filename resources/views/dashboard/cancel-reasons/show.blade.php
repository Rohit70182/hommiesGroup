<?php

use App\Models\CancelReason; ?>
@extends('admin.layouts.app')
@section('content')
<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="/project/tunesline-yii2-1786/">Home</a></li>
        <li class="active">Cancel Reason</li>
    </ul>
</div>
<div class="col-md-12">
    <div class="page-head-text">
        <div class="ProfileHader d-flex flex-wrap align-items-center">
            <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Cancel Reason</h3>
        </div>
    </div>
    <div class="card">
        <div class="card-header ">
        {{$cancelreasons->messages}}
        </div>
    </div>
    <div class="col-md-12">
                    <div class="form-group">
                        <a href="{{route('cancelReasons')}}" class="btn btn-bg mt-4" name="submit" value="Submit">Go Back</a>
                    </div>
                </div>

   
</div>
</div>

</div>
@endsection