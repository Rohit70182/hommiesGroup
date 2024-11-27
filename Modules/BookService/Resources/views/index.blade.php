<?php 
    use Modules\BookService\Entities\Booking; 
?>
@extends('admin.layouts.app')
@section('content')

<div class="mb-1 mt-2">
    <ul class="breadcrumb">
        <li><a href="{{url('/dashboard')}}">Home</a></li>
        <li class="active">Bookings</li>
    </ul>
</div>

<div class="dash-home-cards">
    <div class="row">
        <div class="col-12">
        
        <div class="page-head-text">
                     <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Bookings</h3>
                    </div>
                </div>
                <div class="page-index">
                Index
                </div>
        
            <div class="card">
                <div class="card-header">
                    <div class="ProfileHader d-flex flex-wrap align-items-center">
                        <h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Bookings</h3>
                    </div>

                </div>
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered project">
                        <thead>
                            <th>Id</th>
                            <th>Service/Event Name</th>
                            <th>Booking Type</th>
                            <th>Date</th>
                            <th>Start</th>
                            <th>Addresss</th>
                            <th>Actions</th>  
                        </thead>
                        <tbody>
                     @foreach($bookings as $booking)
                            <tr>
                                <td>{{$booking->id}}</td>
                                @if(!empty($booking->event_id))
                                	<td>{{$booking->event->title}}</td>
                                @else
                                	<td>{{$booking->getService->name}}</td> 
                                @endif
                                <td>
                                    @if($booking->type_id == Booking::TYPE_EVENT)
                                    	Event
                                    @else
                                    	Service 
                                    @endif
                                </td>
                                <td>
                                	@php
                                		$dateString = $booking->date;
                                		$dateArray = explode(" ",$dateString);
                                	@endphp
                                	@if(!empty($dateArray[0]))
                                		{{ $dateArray[0] }}
                                	@else
                                		-----
                                	@endif
                                </td>
                                <td>
                                	@php
                                		$timeString = $booking->time_start;
                                		$timeArray = explode(" ",$dateString);
                                	@endphp
                                	@if(!empty($timeArray[1]))
                                		{{ $timeArray[1] }}
                                	@else
                                		-----
                                	@endif
                                </td>
                                <td>
                                	{{ $booking->address->address }}, {{ $booking->address->address_two }}, {{ $booking->address->city }}, {{ $booking->address->state }}
                                </td>
                                <td>
                                <a href="{{ route('show.booking',$booking->id) }}" title="view " class="btn-success btn"><i class="fa fa-eye"></i></a>
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