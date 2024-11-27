@extends('admin.layouts.app')
@section('content')
<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">All-Bookings </h3>
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
                            <th>Title</th>
                            <th>State_ID</th>
                            <th>Type_ID</th>
                            <th>Services</th>
                           
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
<!--                                 <td>{{$booking->id}}</td> -->
<!--                                 <td>{{$booking->getService->name}}</td> -->
<!--                                 <td>{{$booking->getAddOn->name}}</td> -->
<!--                                 <td>{{$booking->date}}</td> -->
<!--                                 <td>{{$booking->time_start}}</td> -->
<!--                                 <td>{{$booking->time_end}}</td> -->
<!--                                 <td>{{$booking->address}}</td> -->
                                <td>
                                    <a href="{{url('/services/booking-req/view/'.$booking->id)}}" title="view " class="btn-success btn " data-method="view" data-trigger-confirm="1" data-pjax-target="#user-grid"><i class="fa fa-eye"></i></a>
                                    <a href="{{url('/services/booking-req/edit/'.$booking->id)}}" title="edit users" class="btn btn-bg" data-method="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="{{url('/services/booking-req/remove/'.$booking->id)}}" onclick="return confirm('Are you sure?')" title="delete user" class="btn-danger btn" data-method="DELETE"><i class="fa fa-trash"></i></a>
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
        $('#datatable').DataTable();
    });
</script>
@endpush