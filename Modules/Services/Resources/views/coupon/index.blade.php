@extends('admin.layouts.app')
@section('content')
<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Services</li>
        <li class="active">Coupons</li>
    </ul>
</div>

<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
            <div class="page-head-text">
                <div class="ProfileHader d-flex flex-wrap align-items-center">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Coupons	</h3>
                    <a class="btn btn-bg" href="{{url('/services/coupon/add')}}">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>

            </div>
            <div class="page-index">Index</div>
            <div class="card">

                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project
                    ">
                        <thead>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>State</th>
                            <th>Actions</th>

                        </thead>
                        <tbody>
                            @foreach($coupons as $coupon)
                            <tr>
                                <td>{{$coupon->id}}</td>
                                <td>{{$coupon->name}}</td>
                                <td>{{$coupon->desc}}</td>
                                <td>{{$coupon->amount}}</td>
                                <td>{{$coupon->getState()}}</td>
                                <td>
                                    <a href="{{url('/services/coupon/show/'.$coupon->id)}}" title="view" class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                                    <a href="{{url('/services/coupon/edit/'.$coupon->id)}}" title="edit" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="{{url('/services/coupon/softDelete/'.$coupon->id)}}" onclick="return confirm('Are you sure to change its state ?')" title="change state" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Data Table CSS -->
<link rel="stylesheet" href="{{asset('public/dataTables/dataTables.min.css')}}">
@endpush
@push('scripts')
<!-- Data Table Script -->
<script src="{{asset('public/dataTables/dataTables.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            order: [
                [0, 'DESC']
            ],
        });
    });
</script>
@endpush