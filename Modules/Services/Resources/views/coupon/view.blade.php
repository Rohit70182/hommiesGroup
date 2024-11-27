<?php

namespace Modules\Services\Entities;

use Modules\Services\Entities\Coupon;
?>

@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Coupons</li>
    </ul>
</div>

<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="page-head-text d-flex flex-wrap justify-content-between">
                <div>
                    <span class=" font_600 font-18 font-md-20 mr-auto pr-20"> {{$coupon->name}}</span>
                    <!--                          	<span class="btn btn-bg">New</span> -->
                    <span class="badge badge-primary">
                        @if($coupon->state_id==Coupon::STATE_ACTIVE)
                        Active
                        @else($coupon->state_id==Coupon::STATE_INACTIVE)
                        InActive
                        @endif
                    </span>

                </div>
                <div>
                    <a href="{{url('/services/coupon/edit/'.$coupon->id)}}" title="edit users" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                    <a href="{{url('/services/coupon/remove/'.$coupon->id)}}" onclick="return confirm('Are you sure to delete this ?')" title="delete user" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
                    <a class="btn btn-bg" href="{{url('services/coupon')}}"> Back</a>
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
                                                    <th>Id</th>
                                                    <td colspan="1">{{$coupon->id}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Title</th>
                                                    <td colspan="1">{{$coupon->name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <td colspan="1">{{$coupon->desc}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Amount</th>
                                                    <td colspan="1">{{$coupon->amount}}</td>
                                                </tr>
                                                <tr>
                                                    <th>State</th>
                                                    <td colspan="1">{{$coupon->getState()}}</td>
                                                </tr>
                                                <tr></tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="mt-3 float-right">
                                    @if($coupon->state_id==Coupon::STATE_ACTIVE)
                                    <a href="{{url('/services/coupon/stateupdate/'.$coupon->id.'/'.Coupon::STATE_INACTIVE)}}" class="btn btn-bg">InActive</a>
                                    @else($coupon->state_id==Coupon::STATE_INACTIVE)
                                    <a href="{{url('/services/coupon/stateupdate/'.$coupon->id.'/'.Coupon::STATE_ACTIVE)}}" class="btn btn-bg">Active</a>
                                    @endif
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