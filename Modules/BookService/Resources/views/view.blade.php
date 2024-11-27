<?php 
    use Modules\BookService\Entities\Booking; 
    use Modules\Services\Entities\AddOnService;
    use Modules\Services\Entities\BookingSubService;
    use Modules\Services\Entities\SubService;
    use App\Models\BookingAddon;
?>
@extends('admin.layouts.app')
@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                    <div class="float-left">
                        <span class=" font_600 font-18 font-md-20 mr-auto pr-20"></span>
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
                                                    <th>Id</th>
                                                    <td colspan="1">{{ $bookings->id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Booking ID</th>
                                                    <td colspan="1">{{$bookings->reference_id}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Service/Event Name</th>
                                                    @if($bookings->type_id == Booking::TYPE_EVENT)
                                                    	<td colspan="1">{{ $bookings->event->title }}</td> 
                                                    @else
                                                    	 <td colspan="1">{{ $bookings->getService->name }}</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                	<th>Customer Name</th>
                                                	<td colspan="1"><?php echo ucwords($bookings->getUser->name); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Booking Type</th>
                                                    @if($bookings->type_id == Booking::TYPE_EVENT)
                                                    	<td colspan="1">Event</td> 
                                                    @else
                                                    	 <td colspan="1">Service</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th>Start Date</th>
                                                    @php
                                                		$dateString = $bookings->date;
                                                		$dateArray = explode(" ",$dateString);
                                                	@endphp
                                                	@if(!empty($dateArray[0]))
                                                		<td colspan="1">{{ $dateArray[0] }}</td>
                                                	@else
                                                		<td colspan="1">-----</td>
                                                	@endif
                                                </tr>
                                                <tr>
                                                    <th>Start Time</th>
                                                    @php
                                                		$timeString = $bookings->time_start;
                                                		$timeArray = explode(" ",$dateString);
                                                	@endphp
                                                	@if(!empty($timeArray[1]))
                                                		<td colspan="1">{{ $timeArray[1] }}</td>
                                                	@else
                                                		<td colspan="1">-----</td>
                                                	@endif
                                                </tr>
                                                <tr>
                                                	<th>Booking Status</th>
                                                	<td colspan="1">
                                                		@switch($bookings->state_id)
                                                			@case(Booking::STATE_PENDING)
                                                				Pending
                                                			@break
                                                			@case(Booking::STATE_CONFIRMED)
                                                				Confirmed
                                                			@break
                                                			@case(Booking::STATE_CANCELLED)
                                                				Cancelled
                                                			@break
                                                			@case(Booking::STATE_COMPLETE)
                                                				Completed
                                                			@break
                                                			@default
                                                				-----
                                                		@endswitch
                                                	</td>
                                                </tr>
                                                <tr>
                                                	<th>Instruction</th>
                                                	<td colspan="1">
                                                		@if(!empty($bookings->instruction))
                                                			{{ $bookings->instruction }}
                                                		@else
                                                			-----
                                                		@endif
                                                	</td>
                                                </tr>
                                                <tr>
                                                	<th>Mobile</th>
                                                	<td colspan="1">{{ $bookings->mobile }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td colspan="1">{{ $bookings->address->address }}, {{ $bookings->address->address_two }}, {{ $bookings->address->city }}, {{ $bookings->address->state }}({{ $bookings->address->postal_code }})</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Price</th>
                                                    <td colspan="1">{{ $bookings->sub_total }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Assigned To</th>
                                                    <td colspan="1">
                                                    	@if($bookings->state_id == Booking::STATE_PENDING || $bookings->state_id == Booking::STATE_CONFIRMED)
                                                    		<form action="{{ url('/booking/assign/'.$bookings->user_id) }}" method='post'>
                                                    		@csrf
                                                    		<input type='hidden' name='booking_id' value="{{ $bookings->id }}">
                                                    		@if(!empty($bookings->service_provider))
                                                    			<select class='select_sp' name='service_provider'>
                                                        			<option disabled>Select Service Provider</option>
                                                        			@foreach($serviceProviders as $serviceProvider)
                                                        				@if($serviceProvider->id == $bookings->service_provider)
                                                        					<option selected value='{{ $serviceProvider->id }}'>{{ $serviceProvider->name }}</option>
                                                        				@else 
                                                        					<option value='{{ $serviceProvider->id }}'>{{ $serviceProvider->name }}</option>
                                                        				@endif
                                                        			@endforeach
                                                        		</select>
                                                    		@else
                                                    			<select class='select_sp' name='service_provider'>
                                                        			<option selected disabled>Select Service Provider</option>
                                                        			@foreach($serviceProviders as $serviceProvider)
                                                        				<option value='{{ $serviceProvider->id }}'>{{ $serviceProvider->name }}</option>
                                                        			@endforeach
                                                        		</select>
                                                        		
                                                    		@endif
                                                    		
                                                    		<button type='submit' class='btn btn-success' name="submit" >Assign</button>
                                                    		{!!$errors->first("service_provider", "<span class='text-danger'>Please select a Service Provider</span>")!!}
                                                    	</form>
                                                    	@elseif($bookings->state_id == Booking::STATE_COMPLETE)
                                                    		Booking is Completed
                                                    	@else
                                                    		 Booking is Cancelled
                                                    	@endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- show sub services start -->
                <div class="page-index">Sub Services</div>
    			<div class="card">
    
    				<div class="card-body table-responsive">
    					<table id="datatable"
    						class="table table-bordered project
                        ">
    						<thead>
    						   	<th>Id</th>
                                <th>Sub Service Name</th>
                                <th>Description</th>
                                <th>Price</th>  
                                <th>Quantity</th>
    						</thead>
    						<tbody>
                                <?php
                                    $getBookingSubs = BookingSubService::where('booking_id',$bookings->id)->get();
                                    if(count($getBookingSubs) > 0) {
                                        foreach($getBookingSubs as $getBoookingSub) {
                                            $getSubService = SubService::where('id',$getBoookingSub->sub_service_id)->first();
                                            ?>
                                        		<tr>
                                        			<td>{{ $getSubService->id }}</td>
                                        			<td>{{ $getSubService->sub_service_name }}</td>
                                        			<td>{{ $getSubService->description }}</td>
                                        			<td>{{ $getSubService->sub_service_price }}</td>
                                        			<td>{{ $getBoookingSub->quantity }}</td>
                                        		</tr>
                                        	<?php
                                        }
                                    } else {
                                        ?>
                                        	<tr>
                                        		<td colspan='5' style='text-align:center;'>No Sub Service in this booking</td>
                                        	</tr>
                                        <?php
                                    }
                                    
                                ?>
    						</tbody>
    					</table>
    				</div>
    			</div>
    			<!-- show sub services end -->
    			<!-- show sub services start -->
                <div class="page-index">Add-Ons</div>
    			<div class="card">
    
    				<div class="card-body table-responsive">
    					<table id="datatable"
    						class="table table-bordered project
                        ">
    						<thead>
    						   	<th>Id</th>
                                <th>Add On Name</th>
                                <th>Description</th>
                                <th>Price</th>  
                                <th>Quantity</th>
    						</thead>
    						<tbody>
                                <?php
                                    $getBookingAddOns = BookingAddon::where('booking_id',$bookings->id)->get();
                                    if(count($getBookingAddOns) > 0) {
                                        foreach($getBookingAddOns as $getBoookingAddOn) {
                                            $getAddOn = AddOnService::where('id',$getBoookingAddOn->addon_id)->first();
                                            ?>
                                        		<tr>
                                        			<td>{{ $getAddOn->id }}</td>
                                        			<td>{{ $getAddOn->name }}</td>
                                        			<td>{{ $getAddOn->desc }}</td>
                                        			<td>{{ $getAddOn->price }}</td>
                                        			<td>{{ $getBoookingAddOn->quantity }}</td>
                                        		</tr>
                                        	<?php
                                        }
                                    } else {
                                        ?>
                                        	<tr>
                                        		<td colspan="5" style='text-align:center;'>No Add-On in this booking</td>
                                        	</tr>
                                        <?php
                                    }
                                    
                                ?>
    						</tbody>
    					</table>
    				</div>
    			</div>
    			<!-- show sub services end -->
            </div>
        </div>
    </div>
</section>
@endsection