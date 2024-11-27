@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Bookings Request</li>
    </ul>
</div>

<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">All Bookings </h3>
                       @if (Auth::user() && Auth::user()->role == App\Models\User::ROLE_USER)
                        <a class="btn btn-bg" href="{{url('/services/booking-req/add')}}">
                            <i class="fa fa-plus"></i>
                        </a>
                        @endif
                    </div>

                </div>
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project
                    ">
                        <thead>
                            <th>Id</th>
                            <th>Service Name</th>
                            <th>AddOn</th>
                            <th>Date</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Addresss</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td>{{$booking->id}}</td>
                                <td>{{$booking->service_id ? $booking->getService->name : ''}}</td>
                                <td>{{$booking->addOn_id ? $booking->getAddOn->name : ''}}</td>
                                <td>{{$booking->date}}</td>
                                <td>{{$booking->time_start}}</td>
                                <td>{{$booking->time_end}}</td>
                                <td>{{$booking->address_id}}</td>
                                <td>
                                    <a href="{{url('/services/booking-req/view/'.$booking->id)}}" title="view " class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                                    <a href="{{url('/services/booking-req/remove/'.$booking->id)}}" onclick="return confirm('Are you sure to delete this booking ?')" title="delete" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
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