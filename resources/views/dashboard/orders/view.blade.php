@extends('admin.layouts.app') @section('content')
<?php 
    use Modules\BookService\Entities\Booking; 
    use App\Models\OrderDetail;
?>
<div class="mb-1 mt-2">
	<ul class="breadcrumb">
		<li><a href="{{url('/dashboard')}}">Home</a></li>
		<li class="active">Show Order</li>
	</ul>
</div>

<section class="content container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="page-head-text">
				<div class="ProfileHader d-flex flex-wrap align-items-center">
					<h3 class="font_600 font-18 font-md-20 mr-auto pr-20">Show Order</h3>

					<a class="btn btn-bg ml-1" href="{{url('services')}}"> Back</a>
				</div>

			</div>
			<div class="card">

				<div class="card-body col-md-12 mt-2">
					<div class="form-group">
						<div class="col-md-9">
							<div class="card-body">
								<div class="table-responsive">
									<table id="analytics-detail-view"
										class="table table-striped table-bordered detail-view">
										<tbody>
											<tr>
												<th>Id</th>
												<td colspan="1">{{$order->id}}</td>
											</tr>
											<tr>
												<th>Order Id</th>
												<td colspan="1">{{$order->reference_id}}</td>
											</tr>

                                        <?php
                            $bookings =Booking::where([
                               [ 'reference_id' , $order->reference_id],
                                ['state_id' ,'!=' , OrderDetail::STATE_CONFIRM]])->get();
                            
                                $count_booking = count($bookings);
                              
                                if($count_booking == OrderDetail::STATE_PENDING){
                                    $orderDetail = OrderDetail::where('reference_id',$order->reference_id)->pluck('state_id')->first();
                                    if($orderDetail == OrderDetail::STATE_PENDING) {
                                        $updatestate = OrderDetail::where('reference_id',$order->reference_id)->update(['state_id'=>OrderDetail::STATE_CONFIRM]);
                                    }
                                }
                                
                           
                            ?>

											<th>State</th>
											@switch($order->state_id)
                                              	@case(0)
                                              		<td colspan="1">Pending</td>
                                              	@break;
                                              	@case(1)
                                              		<td colspan="1">Confirmed</td>
                                              	@break;
                                              	@case(2)
                                              		<td colspan="1">Completed</td>
                                              	@break;
                                              	@default
                                              		<td colspan="1">Cancelled</td>
                                              @endswitch
											</tr>
											<tr>
												<th>Sub Total</th>
												<td>{{$order->sub_total }}</td>
											</tr>
											<tr>
												<th>Discount</th>
												<td>{{$order->discount }}</td>
											</tr>
											<tr>
												<th>Total Amount</th>
												<td>{{$order->total_amount }}</td>
											</tr>
										</tbody>
									</table>
								</div>


</section>

			<div class="page-index">Bookings</div>
			<div class="card">

				<div class="card-body table-responsive">
					<table id="datatable"
						class="table table-bordered project
                    ">
						<thead>
						     <th>Id</th>
                            <th>Service/Event Name</th>
                            <th>Booking Type</th>
                            <th>Date</th>
                            <th>Start</th>
                            <th>Addresss</th>
                            <th>State</th>
                            <th>Actions</th>  
						</thead>
						<tbody>
                            <?php
                            $bookings =Booking::where('reference_id', $order->reference_id)->get();
                            ?>
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
                                
                            	@switch($booking->state_id)
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
