@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Orders</li>
    </ul>
</div>
<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
            <div class="page-head-text">
                <div class="ProfileHader d-flex flex-wrap align-items-center">
                    <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Orders</h3>
                </div>

            </div>
            <div class="page-index">
                Index
            </div>
            <div class="card">

                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project
                    ">
                        <thead>
                            <th>Id</th>
                            <th>Order Id</th>
                            <th>State</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                          <td>{{$order->id}}</td>
                          <td>{{$order->reference_id}}</td>
                          @switch($order->state_id)
                          	@case(0)
                          		<td>Pending</td>
                          	@break;
                          	@case(1)
                          		<td>Confirmed</td>
                          	@break;
                          	@case(2)
                          		<td>Completed</td>
                          	@break;
                          	@default
                          		<td>Cancelled</td>
                          @endswitch
                                <td>
                                    <a href="{{route('order.show' , $order->id)}}" title="view" class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
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
                [0, 'desc']
            ],
        });
    });
</script>
@endpush