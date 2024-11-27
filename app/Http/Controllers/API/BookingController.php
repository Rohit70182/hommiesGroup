<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\BookService\Entities\Booking;
use Modules\ServiceProvider\Entities\BookServiceProvider;
use Modules\ServiceProvider\Entities\ServiceProvider;
use Modules\Services\Entities\CustomReq;
use function GuzzleHttp\json_decode;
use App\Models\BookingAddon;
use Illuminate\Support\Str;
use Modules\Services\Entities\Coupon;
use App\Models\Event;
use Modules\Services\Entities\Service;
use Modules\Services\Entities\AddOnService;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
// use Illuminate\Notifications\Notification;
use Modules\Notification\Services\UserNotificationService;
use Modules\Notification\Entities\Notification;
use Modules\BookService\Entities\Custom;
use App\Models\CustomReqFiles;
use Modules\Services\Entities\SubService;
use Modules\Services\Entities\BookingSubService;
use App\Models\CancelReason;
use App\Models\OrderDetail;
use Stripe\Order;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * @OA\Get(
     *      path="/booking/service-provider-list",
     *      operationId="providers",
     *      tags={"booking"},
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service Provider List",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="name", type="string", example="service one"),
     *     )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function serviceProviders()
    {
        $provider = ServiceProvider::get();
        if ($provider->isNotEmpty()) {
            return response()->json([
                'list' => $provider,
                'message' => 'service provider list'
            ], 200);
        } else {
            return response(['message' => 'Not found'], 400);
        }
    }
    
    /**
     * @OA\Post(
     *      path="/booking/service",
     *      operationId="addBooking",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *
     *   @OA\RequestBody(
     *
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     
     *              required={"date","time_start","address_id","mobile","type_id"},
     *              @OA\Property(property="type_id", type="integer", format="number", example="1 for service 2 for event"),
     *              @OA\Property(property="service_id", type="integer", format="number", example="12"),
     *              @OA\Property(property="service_cat", type="integer", format="number", example="1"),
     *              @OA\Property(property="service_sub_cat", type="integer", format="number", example="2"),
     *              @OA\Property(property="addon", type="string", example="[{'id':1, 'qty':1},{'id':2, 'qty':2},{'id':3, 'qty':3},{'id':4, 'qty':5}]"),
     *              @OA\Property(property="sub_services", type="string", example="[{'id':1, 'qty':1},{'id':2, 'qty':2},{'id':3, 'qty':3},{'id':4, 'qty':5}]"),
     *              @OA\Property(property="instruction", type="text", format="text", example="Write the Instructions"),
     *              @OA\Property(property="date", type="string", format="number", example="2022-10-10"),
     *              @OA\Property(property="time_start", type="string", format="number", example="10:10"),
     *              @OA\Property(property="time_end", type="string", format="number", example="10:10"),
     *              @OA\Property(property="address_id", type="integer", format="number", example="24"),
     *              @OA\Property(property="mobile", type="string", example="9187678965"),
     *              @OA\Property(property="promo_id", type="string", format="number", example="promoCode"),
     *              @OA\Property(property="event_id", type="integer", format="number", example="24"),
     *           ),
     *       ),
     *   ),
     *
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example=" successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Profile  Updated successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    public function add(Request $request)
    {
        $validator = validator($request->all(), [
            'type_id'         => 'required|integer',
            'service_id'      => 'nullable|required_if:type_id,"==",1',
            'service_cat'     => 'nullable',
            'service_sub_cat' => 'nullable',
            'instruction'     => 'nullable',
            'addon'           => 'nullable',
            'date'            => 'required|date_format:Y-m-d',
            'time_start'      => 'required|date_format:H:i',
            'time_end'        => 'nullable|date_format:H:i',
            'address_id'      => 'required|integer',
            'mobile'          => 'required',
            'promo_id'        => 'nullable',
            'event_id'        => 'nullable|required_if:type_id,"==",2',
        ]);
        
        if ($validator->fails()) 
        {
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        
        if(!empty($request->promo_id)) 
        {
            $couponId = $request->promo_id;
            $getCouponPrice = Coupon::where('id',$couponId)->pluck('amount')->first();
            if(!empty($request->event_id)) {
                $getEventPrice = Event::where('id',$request->event_id)->pluck('price')->first();
                if($getEventPrice <= $getCouponPrice) {
                    return response([
                        'message' => "Sorry! You can't use this coupon as event price is less than coupon price"
                    ], 400);
                }
            } elseif(!empty($request->service_id)) {
                $getServicePrice = Service::where('id',$request->service_id)->pluck('price')->first();
                
                if(!empty($getServicePrice)) {
                    $getServicePrice = $getServicePrice;
                } else {
                    $getServicePrice = 0;
                }
                
                $totalSub = 0;
                
                if(!empty($request->sub_services)) {
                    $subData = $request->sub_services;
                    $subLoop = json_decode($subData);
                    
                    foreach($subLoop as $subDetail) {
                        $subPrice = SubService::where('id',$subDetail->id)->pluck('sub_service_price')->first();
                        $subQty = $subDetail->qty;
                        $finalPrice = $subPrice * $subQty;
                        $totalSub = $totalSub + $finalPrice;
                    }
                }
                
                $getServicePrice = $getServicePrice + $totalSub;
                
                if(!empty($request->addon)) {
                    $addonData = $request->addon;
                    $addOnLoop = json_decode($addonData);
                    
                    $addOnPrices = 0;
                    foreach($addOnLoop as $addOnDetail) {
                        $addOnPrice = AddOnService::where('id',$addOnDetail->id)->pluck('price')->first();
                        $addQty = $addOnDetail->qty;
                        $finalPrice = $addOnPrice * $addQty;
                        $addOnPrices = $addOnPrices + $finalPrice;
                    }
                    $totalPrice = $getServicePrice + $addOnPrices;
                    
                    if($totalPrice <= $getCouponPrice) {
                        return response([
                            'message' => "Sorry! You can't use this coupon as total price is less than coupon price"
                        ], 400);
                    }
                }elseif($getServicePrice <= $getCouponPrice) {
                    return response([
                        'message' => "Sorry! You can't use this coupon as service price is less than coupon price"
                    ], 400);
                }
            }
        }
        
        $orderId = '#'.Str::upper(Str::random(12));
        
        DB::beginTransaction();
        
        $bookings = new Booking();
        $bookings->user_id = Auth::id();
        $bookings->service_id = $request->service_id;
        $bookings->category_id = $request->service_cat;
        $bookings->subcategory_id = $request->service_sub_cat;
        $bookings->type_id = $request->type_id;
        $bookings->state_id = Booking::STATE_PENDING;
        $bookings->instruction = $request->instruction;
        $bookings->reference_id = $orderId;
        $bookings->date = $request->date.' '.$request->time_start;
        $bookings->time_start = $request->date.' '.$request->time_start;
        $bookings->time_end = $request->date.' '.$request->time_end;
        $bookings->address_id = $request->address_id;
        $bookings->mobile = $request->mobile;
        $bookings->coupon_id = $request->promo_id;
        $bookings->event_id = $request->event_id;
        
        if($bookings->type_id == Booking::TYPE_SERVICE)
        {
            $title ="Your service is booked";
        }
        elseif($bookings->type_id == Booking::TYPE_EVENT)
        {
            $title ="Your event is booked";
        }
        $body="Your booking is successfully booked";
        
        if ($bookings->save())
        {
            
            $createOrder = new OrderDetail();
            $createOrder->reference_id = $orderId;
            $createOrder->user_id = Auth::id();
            if(!$createOrder->save()) {
                DB::rollBack();
            }
            
            $bookingId = $bookings->id;
            
            $addOns = $request->addon;
            
            // adding subservices if there are sub servies or getting the minimum value subservice by default
            
            $subServices = $request->sub_services;
            
            $getServicePrice = Service::where('id',$request->service_id)->pluck('price')->first();
            
            $getSubService = SubService::where('service_id',$request->service_id)->orderBy('sub_service_price')->first();
            
            if(empty($getServicePrice) && !empty($getSubService)) {
                
                if(!empty($subServices)) {
                    
                    $subServices = json_decode($subServices);
                    
                    foreach($subServices as $subService) {
                        $addSub = new BookingSubService();
                        $addSub->booking_id = $bookingId;
                        $addSub->sub_service_id = $subService->id;
                        $addSub->quantity = $subService->qty;
                        
                        if(!$addSub->save()) {
                            DB::rollBack();
                            return response([
                                'message' => 'unexpected error occurred'
                            ], 404);
                        }
                    }
                    
                } else {
                    $addSub = new BookingSubService();
                    $addSub->booking_id = $bookingId;
                    $addSub->sub_service_id = $getSubService->id;
                    $addSub->quantity = 1;
                    
                    if(!$addSub->save()) {
                        DB::rollBack();
                        return response([
                            'message' => 'unexpected error occurred'
                        ], 404);
                    }
                }
            }
            
            // adding booking add-ons if there are addons
            if(!empty($addOns)) 
            {   
                $addOnst = json_decode($addOns);
                
                foreach($addOnst as $addOn) {
                    
                    $bookAdd = new BookingAddon();
                    $bookAdd->booking_id = $bookingId;
                    $bookAdd->addon_id = $addOn->id;
                    $bookAdd->quantity = $addOn->qty;
                    
                    if(!$bookAdd->save()) {
                        DB::rollBack();
                        return response([
                            'message' => 'unexpected error occurred'
                        ], 404);
                    }
                }    
            }
            
            DB::commit();
            
            $notification = new UserNotificationService();
            $notification->createNotification($bookings->user_id,$title,$body,$bookings->user_id,null,Booking::class,$bookings->id);

            // $bookings->sendBookingMailToUser();
            // $details['email'] = Auth::user()->email;
            // $details['subject'] = 'Your booking has been recorded.';
            // SendOrderMail::dispatch($details);
            return response([
                'message' => 'Success, Your booking is successfull'
            ], 200);
        }
        else
        {
            DB::rollBack();
            return response([
                'message' => 'unexpected error occurred'
            ], 404);
        }
    }
    
    /**
     * @OA\Post(
     *      path="/booking/edit-cart",
     *      operationId="editCartItem",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *
     *   @OA\RequestBody(
     *
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     
     *              required={"date","time_start","address_id","mobile","type_id","booking_id"},
     *              @OA\Property(property="booking_id", type="integer", format="number", example="1"),
     *              @OA\Property(property="addon", type="string", example="[{'id':1, 'qty':1},{'id':2, 'qty':2},{'id':3, 'qty':3},{'id':4, 'qty':5}]"),
     *              @OA\Property(property="sub_services", type="string", example="[{'id':1, 'qty':1},{'id':2, 'qty':2},{'id':3, 'qty':3},{'id':4, 'qty':5}]"),
     *              @OA\Property(property="instruction", type="text", format="text", example="Write the Instructions"),
     *              @OA\Property(property="date", type="string", format="number", example="2022-10-10"),
     *              @OA\Property(property="time_start", type="string", format="number", example="10:10"),
     *              @OA\Property(property="time_end", type="string", format="number", example="10:10"),
     *              @OA\Property(property="address_id", type="integer", format="number", example="24"),
     *              @OA\Property(property="mobile", type="string", example="9187678965"),
     *           ),
     *       ),
     *   ),
     *
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example=" successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Profile  Updated successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    
    public function editCartItem(Request $request) 
    {
        $validator = validator($request->all(), [
            'instruction'     => 'nullable',
            'addon'           => 'nullable',
            'sub_services'    => 'nullable',
            'date'            => 'required|date_format:Y-m-d',
            'time_start'      => 'required|date_format:H:i',
            'time_end'        => 'nullable|date_format:H:i',
            'address_id'      => 'required|integer',
            'mobile'          => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        
        $getCartItem = Booking::
        
        DB::beginTransaction();
        
        $bookings = new Booking();
        $bookings->user_id = Auth::id();
        $bookings->service_id = $request->service_id;
        $bookings->category_id = $request->service_cat;
        $bookings->subcategory_id = $request->service_sub_cat;
        $bookings->type_id = $request->type_id;
        $bookings->state_id = Booking::STATE_PENDING;
        $bookings->instruction = $request->instruction;
        $bookings->reference_id = $orderId;
        $bookings->date = $request->date.' '.$request->time_start;
        $bookings->time_start = $request->date.' '.$request->time_start;
        $bookings->time_end = $request->date.' '.$request->time_end;
        $bookings->address_id = $request->address_id;
        $bookings->mobile = $request->mobile;
        $bookings->coupon_id = $request->promo_id;
        $bookings->event_id = $request->event_id;
        
        if($bookings->type_id == Booking::TYPE_SERVICE)
        {
            $title ="Your service is booked";
        }
        elseif($bookings->type_id == Booking::TYPE_EVENT)
        {
            $title ="Your event is booked";
        }
        $body="Your booking is successfully booked";
        
        if ($bookings->save())
        {
            
            $createOrder = new OrderDetail();
            $createOrder->reference_id = $orderId;
            $createOrder->user_id = Auth::id();
            if(!$createOrder->save()) {
                DB::rollBack();
            }
            
            $bookingId = $bookings->id;
            
            $addOns = $request->addon;
            
            // adding subservices if there are sub servies or getting the minimum value subservice by default
            
            $subServices = $request->sub_services;
            
            $getServicePrice = Service::where('id',$request->service_id)->pluck('price')->first();
            
            $getSubService = SubService::where('service_id',$request->service_id)->orderBy('sub_service_price')->first();
            
            if(empty($getServicePrice) && !empty($getSubService)) {
                
                if(!empty($subServices)) {
                    
                    $subServices = json_decode($subServices);
                    
                    foreach($subServices as $subService) {
                        $addSub = new BookingSubService();
                        $addSub->booking_id = $bookingId;
                        $addSub->sub_service_id = $subService->id;
                        $addSub->quantity = $subService->qty;
                        
                        if(!$addSub->save()) {
                            DB::rollBack();
                            return response([
                                'message' => 'unexpected error occurred'
                            ], 404);
                        }
                    }
                    
                } else {
                    $addSub = new BookingSubService();
                    $addSub->booking_id = $bookingId;
                    $addSub->sub_service_id = $getSubService->id;
                    $addSub->quantity = 1;
                    
                    if(!$addSub->save()) {
                        DB::rollBack();
                        return response([
                            'message' => 'unexpected error occurred'
                        ], 404);
                    }
                }
            }
            
            // adding booking add-ons if there are addons
            if(!empty($addOns))
            {
                $addOnst = json_decode($addOns);
                
                foreach($addOnst as $addOn) {
                    
                    $bookAdd = new BookingAddon();
                    $bookAdd->booking_id = $bookingId;
                    $bookAdd->addon_id = $addOn->id;
                    $bookAdd->quantity = $addOn->qty;
                    
                    if(!$bookAdd->save()) {
                        DB::rollBack();
                        return response([
                            'message' => 'unexpected error occurred'
                        ], 404);
                    }
                }
            }
            
            DB::commit();
            
            $notification = new UserNotificationService();
            $notification->createNotification($bookings->user_id,$title,$body,$bookings->user_id,null,Booking::class,$bookings->id);
            
            // $bookings->sendBookingMailToUser();
            // $details['email'] = Auth::user()->email;
            // $details['subject'] = 'Your booking has been recorded.';
            // SendOrderMail::dispatch($details);
            return response([
                'message' => 'Success, Your booking is successfull'
            ], 200);
        }
        else
        {
            DB::rollBack();
            return response([
                'message' => 'unexpected error occurred'
            ], 404);
        }
    }
    
    /**
     * @OA\Post(
     *      path="/booking/service-provider",
     *      operationId="serviceProviderBooking",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *
     *   @OA\RequestBody(
     *
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"date","time_start","address_id","mobile","type_id","service_provider_id"},
     *              @OA\Property(property="service_provider_id", type="integer", format="number", example="1"),
     *              @OA\Property(property="type_id", type="integer", format="number", example="1 for service 2 for event"),
     *              @OA\Property(property="service_id", type="integer", format="number", example="12"),
     *              @OA\Property(property="service_cat", type="integer", format="number", example="1"),
     *              @OA\Property(property="service_sub_cat", type="integer", format="number", example="2"),
     *              @OA\Property(property="addon", type="string", example="[{'id':1, 'qty':1},{'id':2, 'qty':2},{'id':3, 'qty':3},{'id':4, 'qty':5}]"),
     *              @OA\Property(property="sub_services", type="string", example="[{'id':1, 'qty':1},{'id':2, 'qty':2},{'id':3, 'qty':3},{'id':4, 'qty':5}]"),
     *              @OA\Property(property="instruction", type="text", format="text", example="Write the Instructions"),
     *              @OA\Property(property="date", type="string", format="number", example="2022-10-10"),
     *              @OA\Property(property="time_start", type="string", format="number", example="10:10"),
     *              @OA\Property(property="time_end", type="string", format="number", example="10:10"),
     *              @OA\Property(property="address_id", type="integer", format="number", example="24"),
     *              @OA\Property(property="mobile", type="string", example="9187678965"),
     *              @OA\Property(property="promo_id", type="string", format="number", example="promoCode"),
     *              @OA\Property(property="event_id", type="integer", format="number", example="24"),
     *           ),
     *       ),
     *   ),
     *
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example=" successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Profile  Updated successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    public function bookServiceProvider(Request $request) {
        $validator = validator($request->all(), [
            'service_provider_id' => 'required|integer',
            'type_id'         => 'required|integer',
            'service_id'      => 'nullable|required_if:type_id,"==",1',
            'service_cat'     => 'nullable',
            'service_sub_cat' => 'nullable',
            'instruction'     => 'nullable',
            'addon'           => 'nullable',
            'date'            => 'required|date_format:Y-m-d',
            'time_start'      => 'required|date_format:H:i',
            'time_end'        => 'nullable|date_format:H:i',
            'address_id'      => 'required|integer',
            'mobile'          => 'required',
            'promo_id'        => 'nullable',
            'event_id'        => 'nullable|required_if:type_id,"==",2',
        ]);
        
        if ($validator->fails())
        {
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        
        $ProviderDetail = ServiceProvider::where('id',$request->service_provider_id)->first();
        
        $startTime = $request->time_start.":00";
        
        if(!empty($ProviderDetail)) {
            if($ProviderDetail->end_time < $startTime || $ProviderDetail->start_time > $startTime) {
                return response([
                    'message' => "Service Provider is not avialable at this time. So, please choose another service provider"
                ], 400);
            }
        } else {
            return response([
                'message' => "No Service Provider Found"
            ], 400);
        }
        
        if(!empty($request->promo_id))
        {
            $couponId = $request->promo_id;
            $getCouponPrice = Coupon::where('id',$couponId)->pluck('amount')->first();
            if(!empty($request->event_id)) {
                $getEventPrice = Event::where('id',$request->event_id)->pluck('price')->first();
                if($getEventPrice <= $getCouponPrice) {
                    return response([
                        'message' => "Sorry! You can't use this coupon as event price is less than coupon price"
                    ], 400);
                }
            } elseif(!empty($request->service_id)) {
                $getServicePrice = Service::where('id',$request->service_id)->pluck('price')->first();
                
                if(!empty($getServicePrice)) {
                    $getServicePrice = $getServicePrice;
                } else {
                    $getServicePrice = 0;
                }
                
                $totalSub = 0;
                
                if(!empty($request->sub_services)) {
                    $subData = $request->sub_services;
                    $subLoop = json_decode($subData);
                    
                    foreach($subLoop as $subDetail) {
                        $subPrice = SubService::where('id',$subDetail->id)->pluck('sub_service_price')->first();
                        $subQty = $subDetail->qty;
                        $finalPrice = $subPrice * $subQty;
                        $totalSub = $totalSub + $finalPrice;
                    }
                }
                
                $getServicePrice = $getServicePrice + $totalSub;
                
                if(!empty($request->addon)) {
                    $addonData = $request->addon;
                    $addOnLoop = json_decode($addonData);
                    
                    $addOnPrices = 0;
                    foreach($addOnLoop as $addOnDetail) {
                        $addOnPrice = AddOnService::where('id',$addOnDetail->id)->pluck('price')->first();
                        $addQty = $addOnDetail->qty;
                        $finalPrice = $addOnPrice * $addQty;
                        $addOnPrices = $addOnPrices + $finalPrice;
                    }
                    $totalPrice = $getServicePrice + $addOnPrices;
                    
                    if($totalPrice <= $getCouponPrice) {
                        return response([
                            'message' => "Sorry! You can't use this coupon as total price is less than coupon price"
                        ], 400);
                    }
                }elseif($getServicePrice <= $getCouponPrice) {
                    return response([
                        'message' => "Sorry! You can't use this coupon as service price is less than coupon price"
                    ], 400);
                }
            }
        }
        
        $orderId = '#'.Str::upper(Str::random(12));
        
        $bookings = new Booking();
        $bookings->user_id = Auth::id();
        $bookings->service_id = $request->service_id;
        $bookings->category_id = $request->service_cat;
        $bookings->subcategory_id = $request->service_sub_cat;
        $bookings->type_id = $request->type_id;
        $bookings->state_id = Booking::STATE_PENDING;
        $bookings->instruction = $request->instruction;
        $bookings->reference_id = $orderId;
        $bookings->date = $request->date.' '.$request->time_start;
        $bookings->time_start = $request->date.' '.$request->time_start;
        $bookings->time_end = $request->date.' '.$request->time_end;
        $bookings->address_id = $request->address_id;
        $bookings->mobile = $request->mobile;
        $bookings->coupon_id = $request->promo_id;
        $bookings->service_provider = $request->service_provider_id;
        $bookings->event_id = $request->event_id;
        
        if($bookings->type_id == Booking::TYPE_SERVICE)
        {
            $title ="Your service is booked";
        }
        elseif($bookings->type_id == Booking::TYPE_EVENT)
        {
            $title ="Your event is booked";
        }
        $body="Your booking is successfully booked";
        
        if ($bookings->save())
        {
            
            $createOrder = new OrderDetail();
            $createOrder->reference_id = $orderId;
            $createOrder->user_id = Auth::id();
            $createOrder->save();
            
            $bookingId = $bookings->id;
            
            $addOns = $request->addon;
            
            // adding subservices if there are sub servies or getting the minimum value subservice by default
            
            $subServices = $request->sub_services;
            
            $getServicePrice = Service::where('id',$request->service_id)->pluck('price')->first();
            
            $getSubService = SubService::where('service_id',$request->service_id)->orderBy('sub_service_price')->first();
            
            if(empty($getServicePrice) && !empty($getSubService)) {
                
                if(!empty($subServices)) {
                    
                    $subServices = json_decode($subServices);
                    
                    foreach($subServices as $subService) {
                        $addSub = new BookingSubService();
                        $addSub->booking_id = $bookingId;
                        $addSub->sub_service_id = $subService->id;
                        $addSub->quantity = $subService->qty;
                        
                        if(!$addSub->save()) {
                            return response([
                                'message' => 'unexpected error occurred'
                            ], 404);
                        }
                    }
                    
                } else {
                    $addSub = new BookingSubService();
                    $addSub->booking_id = $bookingId;
                    $addSub->sub_service_id = $getSubService->id;
                    $addSub->quantity = 1;
                    
                    if(!$addSub->save()) {
                        return response([
                            'message' => 'unexpected error occurred'
                        ], 404);
                    }
                }
            }
            
            // adding booking add-ons if there are addons
            if(!empty($addOns))
            {
                $addOnst = json_decode($addOns);
                
                foreach($addOnst as $addOn) {
                    
                    $bookAdd = new BookingAddon();
                    $bookAdd->booking_id = $bookingId;
                    $bookAdd->addon_id = $addOn->id;
                    $bookAdd->quantity = $addOn->qty;
                    
                    if(!$bookAdd->save()) {
                        return response([
                            'message' => 'unexpected error occurred'
                        ], 404);
                    }
                }
            }
            
            $notification = new UserNotificationService();
            $notification->createNotification($bookings->user_id,$title,$body,$bookings->user_id,null,Booking::class,$bookings->id);
            
            // $bookings->sendBookingMailToUser();
            // $details['email'] = Auth::user()->email;
            // $details['subject'] = 'Your booking has been recorded.';
            // SendOrderMail::dispatch($details);
            return response([
                'message' => 'Success, Your booking is successfull'
            ], 200);
        }
        else
        {
            return response([
                'message' => 'unexpected error occurred'
            ], 404);
        }
    }
    
    /**
     * @OA\Post(
     *      path="/booking/add-cart",
     *      operationId="addBookingToCart",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *
     *   @OA\RequestBody(
     *
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"date","time_start","address_id","mobile","type_id"},
     *              @OA\Property(property="type_id", type="integer", format="number", example="1 for service 2 for event"),
     *              @OA\Property(property="service_id", type="integer", format="number", example="12"),
     *              @OA\Property(property="service_cat", type="integer", format="number", example="1"),
     *              @OA\Property(property="service_sub_cat", type="integer", format="number", example="2"),
     *              @OA\Property(property="addon", type="string", example="[{'id':1, 'qty':1},{'id':2, 'qty':2},{'id':3, 'qty':3},{'id':4, 'qty':5}]"),
     *              @OA\Property(property="sub_services", type="string", example="[{'id':1, 'qty':1},{'id':2, 'qty':2},{'id':3, 'qty':3},{'id':4, 'qty':5}]"),
     *              @OA\Property(property="instruction", type="text", format="text", example="Write the Instructions"),
     *              @OA\Property(property="date", type="string", format="number", example="2022-10-10"),
     *              @OA\Property(property="time_start", type="string", format="number", example="10:10"),
     *              @OA\Property(property="time_end", type="string", format="number", example="10:10"),
     *              @OA\Property(property="address_id", type="integer", format="number", example="24"),
     *              @OA\Property(property="mobile", type="string", example="9187678965"),
     *              @OA\Property(property="event_id", type="integer", format="number", example="24"),
     *           ),
     *       ),
     *   ),
     *
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example=" successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Profile  Updated successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    
    public function addToCart(Request $request) {
        
        $validator = validator($request->all(), [
            'type_id'         => 'required|integer',
            'service_id'      => 'nullable|required_if:type_id,"==",1',
            'service_cat'     => 'nullable',
            'service_sub_cat' => 'nullable',
            'instruction'     => 'nullable',
            'addon'           => 'nullable',
            'date'            => 'required|date_format:Y-m-d',
            'time_start'      => 'required|date_format:H:i',
            'time_end'        => 'nullable|date_format:H:i',
            'address_id'      => 'required|integer',
            'mobile'          => 'required',
            'event_id'        => 'nullable|required_if:type_id,"==",2',
        ]);
        
        if ($validator->fails())
        {
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        
        $bookings = new Booking();
        $bookings->user_id = Auth::id();
        $bookings->service_id = $request->service_id;
        $bookings->category_id = $request->service_cat;
        $bookings->subcategory_id = $request->service_sub_cat;
        $bookings->type_id = $request->type_id;
        $bookings->state_id = Booking::STATE_DRAFT;
        $bookings->instruction = $request->instruction;
        $bookings->date = $request->date.' '.$request->time_start;
        $bookings->time_start = $request->date.' '.$request->time_start;
        $bookings->time_end = $request->date.' '.$request->time_end;
        $bookings->address_id = $request->address_id;
        $bookings->mobile = $request->mobile;
        $bookings->event_id = $request->event_id;
        
        if ($bookings->save())
        {
            $bookingId = $bookings->id;
            
            $addOns = $request->addon;
            
            // adding subservices if there are sub servies or getting the minimum value subservice by default
            
            $subServices = $request->sub_services;
            
            $getServicePrice = Service::where('id',$request->service_id)->pluck('price')->first();
            
            $getSubService = SubService::where('service_id',$request->service_id)->orderBy('sub_service_price')->first();
            
            if(empty($getServicePrice) && !empty($getSubService)) {
                
                if(!empty($subServices)) {
                    
                    $subServices = json_decode($subServices);
                    
                    foreach($subServices as $subService) {
                        $addSub = new BookingSubService();
                        $addSub->booking_id = $bookingId;
                        $addSub->sub_service_id = $subService->id;
                        $addSub->quantity = $subService->qty;
                        
                        if(!$addSub->save()) {
                            return response([
                                'message' => 'unexpected error occurred'
                            ], 404);
                        }
                    }
                    
                } else {
                    $addSub = new BookingSubService();
                    $addSub->booking_id = $bookingId;
                    $addSub->sub_service_id = $getSubService->id;
                    $addSub->quantity = 1;
                    
                    if(!$addSub->save()) {
                        return response([
                            'message' => 'unexpected error occurred'
                        ], 404);
                    }
                }
            }
            
            // adding booking add-ons if there are addons
            if(!empty($addOns))
            {
                $addOnst = json_decode($addOns);
                
                foreach($addOnst as $addOn) {
                    
                    $bookAdd = new BookingAddon();
                    $bookAdd->booking_id = $bookingId;
                    $bookAdd->addon_id = $addOn->id;
                    $bookAdd->quantity = $addOn->qty;
                    
                    if(!$bookAdd->save()) {
                        return response([
                            'message' => 'unexpected error occurred'
                        ], 404);
                    }
                }
            }
           
            return response([
                'message' => 'Success, Your booking is added to cart'
            ], 200);
        }
        else
        {
            return response([
                'message' => 'unexpected error occurred'
            ], 404);
        }
    }
    
    /**
     * @OA\Get(
     *      path="/booking/remove-cart",
     *      operationId="removeBookingFromCart",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *      @OA\Parameter(
     *     name="booking_id",
     *     in="query",
     *     required = true,
     *     @OA\Schema(
     *       type="integer"
     *     ),
     *   ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="user_id", type="integer", example="1"),
     *           @OA\Property(property="service_id", type="integer", example="1"),
     *           @OA\Property(property="category_id", type="integer", example="1"),
     *           @OA\Property(property="subcategory_id", type="integer", example="1"),
     *           @OA\Property(property="date", type="string", example="2022:10:10"),
     *           @OA\Property(property="time_start", type="string", example="10:10"),
     *           @OA\Property(property="time_end", type="string", example="10:10"),
     *           @OA\Property(property="address_id", type="integer", example="1"),
     *           @OA\Property(property="instruction", type="text", example="This is instructions"),
     *           @OA\Property(property="type_id", type="integer", example="1"),
     *           @OA\Property(property="state_id", type="integer", example="1"),
     *           @OA\Property(property="mobile", type="string", example="9876543210"),
     *           @OA\Property(property="coupon_id", type="integer", example="1"),
     *           @OA\Property(property="event_id", type="integer", example="1"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function removeFromCart(Request $request) {
        
        $validator = validator($request->all(), [
            'booking_id'  => 'required|integer',
        ]);
        
        if ($validator->fails())
        {
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        
        $bookingId = $request->booking_id;
       
        $getBooking = Booking::where('id',$bookingId)->first();
        
        if(!empty($getBooking)) {
            if($getBooking->state_id == Booking::STATE_DRAFT) {
                if($getBooking->delete()) {
                    $bookingAddOn = BookingAddon::where('booking_id',$bookingId)->delete();
                    $bookingSubServices = BookingSubService::where('booking_id',$bookingId)->delete();
                    
                    return response([
                        'message' => 'Booking Removed From Cart Successfully'
                    ], 200);
                } else {
                    return response([
                        'message' => 'unexpected error occurred'
                    ], 404);
                }
            } else {
                return response([
                    'message' => 'unexpected error occurred'
                ], 404);
            }
        } else {
            return response([
                'message' => 'unexpected error occurred'
            ], 404);
        }   
    }
    
    /**
     * @OA\post(
     *      path="/booking/book-cart",
     *      operationId="bookCartItems",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *       @OA\RequestBody(
     *
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              @OA\Property(property="promo_id", type="integer", example="1"),
     *           ),
     *       ),
     *   ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="user_id", type="integer", example="1"),
     *           @OA\Property(property="service_id", type="integer", example="1"),
     *           @OA\Property(property="category_id", type="integer", example="1"),
     *           @OA\Property(property="subcategory_id", type="integer", example="1"),
     *           @OA\Property(property="date", type="string", example="2022:10:10"),
     *           @OA\Property(property="time_start", type="string", example="10:10"),
     *           @OA\Property(property="time_end", type="string", example="10:10"),
     *           @OA\Property(property="address_id", type="integer", example="1"),
     *           @OA\Property(property="instruction", type="text", example="This is instructions"),
     *           @OA\Property(property="type_id", type="integer", example="1"),
     *           @OA\Property(property="state_id", type="integer", example="1"),
     *           @OA\Property(property="mobile", type="string", example="9876543210"),
     *           @OA\Property(property="coupon_id", type="integer", example="1"),
     *           @OA\Property(property="event_id", type="integer", example="1"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function bookCart(Request $request) {
        // generating order id on request
        $orderId = '#'.Str::upper(Str::random(12));
        
        // get current user
        $currentUser = Auth::id();
        
        if(!empty($request->promo_id)) {
            $getPromo = Coupon::where('id',$request->promo_id)->first();
            
            if(!empty($getPromo)) {
                
                $promoId = $getPromo->id;
                $promoAmount = $getPromo->amount;
                
                $getBookings = Booking::where([
                    ['state_id',"=",Booking::STATE_DRAFT],
                    ['user_id','=',$currentUser]
                ])->get();
                
                $totalCart = 0;
                
                if(!empty($getBookings)) {
                    foreach($getBookings as $getBooking) {
                        $totalCart += $getBooking->sub_total;
                    }
                }
                
                if($promoAmount > $totalCart) {
                    return response([
                        'message' => 'Promo Code amount is larger than total price'
                    ], 400);
                }
                
                if(!empty($getBookings)) {
                    foreach($getBookings as $getBooking) {
                        $updateBooking = Booking::where('id',$getBooking->id)->update([
                            'reference_id' => $orderId,
                            'promo_amount' => $promoAmount,
                            'state_id' => Booking::STATE_PENDING
                        ]);
                    }
                    
                    $createOrder = new OrderDetail();
                    $createOrder->reference_id = $orderId;
                    $createOrder->user_id = Auth::id();
                    $createOrder->save();
                    
                    return response([
                        'message' => 'Order Placed Successfully!!'
                    ], 200);
                    
                } else {
                    return response([
                        'message' => 'Cart is empty'
                    ], 404);
                }
            } else {
                return response([
                    'message' => 'No coupon Found'
                ], 404);
            }
        } else {
            $getBookings = Booking::where([
                ['state_id',"=",Booking::STATE_DRAFT],
                ['user_id','=',$currentUser]
            ])->get();
            
            if(!empty($getBookings)) {
                foreach($getBookings as $getBooking) {
                    $updateBooking = Booking::where('id',$getBooking->id)->update([
                        'reference_id' => $orderId,
                        'state_id' => Booking::STATE_PENDING
                    ]);
                }
                
                $createOrder = new OrderDetail();
                $createOrder->reference_id = $orderId;
                $createOrder->user_id = Auth::id();
                $createOrder->save();
                
                return response([
                    'message' => 'Order Placed Successfully!!'
                ], 200);
                
            } else {
                return response([
                    'message' => 'Cart is empty'
                ], 404);
            }
        }
    }
    
    /**
     * @OA\Get(
     *      path="/booking/cart/detail",
     *      operationId="cartDetail",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *      
     *      @OA\Parameter(
     *     name="booking_id",
     *     in="query",
     *     @OA\Schema(
     *       type="integer"
     *     ),
     *   ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="user_id", type="integer", example="1"),
     *           @OA\Property(property="service_id", type="integer", example="1"),
     *           @OA\Property(property="category_id", type="integer", example="1"),
     *           @OA\Property(property="subcategory_id", type="integer", example="1"),
     *           @OA\Property(property="date", type="string", example="2022:10:10"),
     *           @OA\Property(property="time_start", type="string", example="10:10"),
     *           @OA\Property(property="time_end", type="string", example="10:10"),
     *           @OA\Property(property="address_id", type="integer", example="1"),
     *           @OA\Property(property="instruction", type="text", example="This is instructions"),
     *           @OA\Property(property="type_id", type="integer", example="1"),
     *           @OA\Property(property="state_id", type="integer", example="1"),
     *           @OA\Property(property="mobile", type="string", example="9876543210"),
     *           @OA\Property(property="coupon_id", type="integer", example="1"),
     *           @OA\Property(property="event_id", type="integer", example="1"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function getCartDetail(Request $request) {
        
        $currentUser = Auth::id();
        
        if(!empty($request->booking_id)) {
            $getCartItem = Booking::where([
                ['user_id',"=",$currentUser],
                ['state_id',"=",Booking::STATE_DRAFT],
                ['id',"=",$request->booking_id]
            ])->with(['bookingAddon','getService','Address','coupon','event','serviceProvider','bookingSubServices'])->first();
            
            if(!empty($getCartItem)) {
                return response([
                    'message' => 'Cart Item Detail',
                    'detail' => $getCartItem,
                ], 200);
            } else {
                return response([
                    'message' => 'Cart is empty',
                ], 404);
            }
        }
        
        $getCartItems = Booking::where([
            ['user_id',"=",$currentUser],
            ['state_id',"=",Booking::STATE_DRAFT],
            
        ])->with(['bookingAddon','getService','Address','coupon','event','serviceProvider','bookingSubServices'])->get();
        

        $totalPrice = 0;
        foreach($getCartItems as $getCartItem) {
            $totalPrice += $getCartItem->total_price;
        }
        
        if(!empty($getCartItems)) {
            return response([
                'message' => 'Cart Items',
                'total_price' => $totalPrice,

                'list' => $getCartItems,
            ], 200);
        } else {
            return response([
                'message' => 'Cart is empty',
            ], 404);
        }
    }
    
    
    /**
     * @OA\Get(
     *      path="/booking/detail",
     *      operationId="bookingDetail",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *      @OA\Parameter(
     *     name="order_id",
     *     in="query",
     *     @OA\Schema(
     *       type="string"
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="show_id",
     *     in="query",
     *     @OA\Schema(
     *       type="integer",
     *       example="1 for pending and confirmed, 2 for cancelled and completed"
     *     ),
     *   ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="user_id", type="integer", example="1"),
     *           @OA\Property(property="service_id", type="integer", example="1"),
     *           @OA\Property(property="category_id", type="integer", example="1"),
     *           @OA\Property(property="subcategory_id", type="integer", example="1"),
     *           @OA\Property(property="date", type="string", example="2022:10:10"),
     *           @OA\Property(property="time_start", type="string", example="10:10"),
     *           @OA\Property(property="time_end", type="string", example="10:10"),
     *           @OA\Property(property="address_id", type="integer", example="1"),
     *           @OA\Property(property="instruction", type="text", example="This is instructions"),
     *           @OA\Property(property="type_id", type="integer", example="1"),
     *           @OA\Property(property="state_id", type="integer", example="1"),
     *           @OA\Property(property="mobile", type="string", example="9876543210"),
     *           @OA\Property(property="coupon_id", type="integer", example="1"),
     *           @OA\Property(property="event_id", type="integer", example="1"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function bookingDetail(Request $request) {
        $currentUser = Auth::id();
      
        if(!empty($request->order_id)) {
            $getOrder = OrderDetail::where([
                ['reference_id','=',$request->order_id],
                ['user_id','=',$currentUser]
            ])->first();
            
            if(!empty($getOrder)) {
                return response([
                    'message' => 'Order Detail',
                    'detail'  =>  $getOrder
                ], 200);
            } else {
                return response([
                    'message' => 'No order found'
                ], 404);
            }
        } else if(!empty($request->show_id))  {
            $showId = $request->show_id;
            $showArray = [1,2];
            if(in_array($showId, $showArray)) {
                if($showId == 1) {
                    $getOrders = OrderDetail::where('user_id',$currentUser)->whereIn('state_id',[OrderDetail::STATE_PENDING,OrderDetail::STATE_CONFIRM])->orderBy('id','desc')->get();
                } else {
                    $getOrders = OrderDetail::where('user_id',$currentUser)->whereIn('state_id',[OrderDetail::STATE_CANCEL,OrderDetail::STATE_COMPLETE])->orderBy('id','desc')->get();
                }
            } else {
                return response([
                    'message' => 'Please enter valid show id'
                ], 400);
            }
            
            if(!empty($getOrders)) {
                return response([
                    'message' => 'Order Detail',
                    'list'  =>  $getOrders
                ], 200);
            } else {
                return response([
                    'message' => 'No order found'
                ], 404);
            }
        }else {
            $getOrders = OrderDetail::where('user_id',$currentUser)->get();
            
            if(!empty($getOrders)) {
                return response([
                    'message' => 'Order Detail',
                    'list'  =>  $getOrders
                ], 200);
            } else {
                return response([
                    'message' => 'No order found'
                ], 404);
            }
        }
        
    }
    
    /**
     * @OA\Get(
     *      path="/booking/cancel-reasons",
     *      operationId="cancelReasons",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="user_id", type="integer", example="1"),
     *           @OA\Property(property="service_id", type="integer", example="1"),
     *           @OA\Property(property="category_id", type="integer", example="1"),
     *           @OA\Property(property="subcategory_id", type="integer", example="1"),
     *           @OA\Property(property="date", type="string", example="2022:10:10"),
     *           @OA\Property(property="time_start", type="string", example="10:10"),
     *           @OA\Property(property="time_end", type="string", example="10:10"),
     *           @OA\Property(property="address_id", type="integer", example="1"),
     *           @OA\Property(property="instruction", type="text", example="This is instructions"),
     *           @OA\Property(property="type_id", type="integer", example="1"),
     *           @OA\Property(property="state_id", type="integer", example="1"),
     *           @OA\Property(property="mobile", type="string", example="9876543210"),
     *           @OA\Property(property="coupon_id", type="integer", example="1"),
     *           @OA\Property(property="event_id", type="integer", example="1"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function cancelReasons() {
        $getCancelReasons = CancelReason::all();
        
        if(!empty($getCancelReasons)) {
            return response([
                'message' => 'Cancel Reasons',
                'list' => $getCancelReasons
            ], 200);
        } else {
            return response([
                'message' => 'unexpected error occurred'
            ], 404);
        }
    }
    
    /**
     * @OA\Get(
     *      path="/booking/service-detail",
     *      operationId="getServiceDetail",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *   @OA\Parameter(
     *     name="booking_id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="integer",
     *     ),
     *   ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="user_id", type="integer", example="1"),
     *           @OA\Property(property="service_id", type="integer", example="1"),
     *           @OA\Property(property="category_id", type="integer", example="1"),
     *           @OA\Property(property="subcategory_id", type="integer", example="1"),
     *           @OA\Property(property="date", type="string", example="2022:10:10"),
     *           @OA\Property(property="time_start", type="string", example="10:10"),
     *           @OA\Property(property="time_end", type="string", example="10:10"),
     *           @OA\Property(property="address_id", type="integer", example="1"),
     *           @OA\Property(property="instruction", type="text", example="This is instructions"),
     *           @OA\Property(property="type_id", type="integer", example="1"),
     *           @OA\Property(property="state_id", type="integer", example="1"),
     *           @OA\Property(property="mobile", type="string", example="9876543210"),
     *           @OA\Property(property="coupon_id", type="integer", example="1"),
     *           @OA\Property(property="event_id", type="integer", example="1"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function serviceDetail(Request $request) {
        $currentUser = Auth::id();
        
        $validator = validator($request->all(), [
            'booking_id' => 'required|integer',
        ]);
        
        if ($validator->fails())
        {
            
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        
        $getBooking = Booking::where([
            ['user_id',"=",$currentUser],
            ['id',"=",$request->booking_id]
        ])->with(['bookingAddon','getService','Address','coupon','event','serviceProvider','bookingSubServices'])->first();
        
        if(!empty($getBooking)) {
            return response([
                'message' => 'Booking Detail',
                'detail' => $getBooking
            ], 200);
        } else {
            return response([
                'message' => 'No Booking Found'
            ], 404);
        }
        
    }
    
    /**
     * @OA\Get(
     *      path="/booking/date-list",
     *      operationId="bookingDateList",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *   @OA\Parameter(
     *     name="date",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="string",
     *       example="2022-12-21"
     *     ),
     *   ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="user_id", type="integer", example="1"),
     *           @OA\Property(property="service_id", type="integer", example="1"),
     *           @OA\Property(property="category_id", type="integer", example="1"),
     *           @OA\Property(property="subcategory_id", type="integer", example="1"),
     *           @OA\Property(property="date", type="string", example="2022:10:10"),
     *           @OA\Property(property="time_start", type="string", example="10:10"),
     *           @OA\Property(property="time_end", type="string", example="10:10"),
     *           @OA\Property(property="address_id", type="integer", example="1"),
     *           @OA\Property(property="instruction", type="text", example="This is instructions"),
     *           @OA\Property(property="type_id", type="integer", example="1"),
     *           @OA\Property(property="state_id", type="integer", example="1"),
     *           @OA\Property(property="mobile", type="string", example="9876543210"),
     *           @OA\Property(property="coupon_id", type="integer", example="1"),
     *           @OA\Property(property="event_id", type="integer", example="1"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function bookingDateList(Request $request) {
        
        $validator = validator($request->all(), [
            'date' => 'required|date_format:Y-m-d',
        ]);
        
        if ($validator->fails())
        {
            
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        
        $date = $request->date;
        
        $bookingList = Booking::query();

        $bookingList = $bookingList->where('date','LIKE','%'.$date.'%')->with(['bookingAddon','getService','Address','coupon','event','serviceProvider','bookingSubServices'])->get();
        
        if(!empty($bookingList)) {

            return response()->json([
                'list' => $bookingList,
                'message' => 'Bookings list'
            ], 200);
        } else {
            return response([
                'message' => 'No Booking Found'
            ], 400);
        }
    }
    
    /**
     * @OA\Post(
     *      path="/booking/cancel",
     *      operationId="cancelBooking",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *     @OA\Parameter(
     *     name="order_id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="string"
     *     ),
     *   ),
     *   @OA\RequestBody(
     *
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              @OA\Property(property="reason_id", type="integer", format="number", example="1"),
     *              @OA\Property(property="reason_message", type="string", format="text", example="This is the message"),
     *           ),
     *       ),
     *   ),
     *   @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example=" successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Profile  Updated successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    
    public function cancel(Request $request) {
        
        $validator = validator($request->all(), [
            'order_id' => 'required',
            'reason_id' => 'integer|nullable|required_without:reason_message',
            'reason_message' => 'string|nullable|required_without:reason_id',
        ]);
        
        if ($validator->fails())
        {
            return response([
                "status" => 400,
                'message' => 'Unexpected error occurred'
            ], 400);
        }
        
        if(!empty($request->reason_id) && !empty($request->reason_message)) {
            return response([
                "status" => 400,
                'message' => 'Please enter either reason id or reason message'
            ], 400);
        }
        
        if(!empty($request->reason_id)) {
            
            $checkReason = CancelReason::where('id',$request->reason_id)->first();
            
            if(!empty($checkReason)) {
                
                if(!empty($request->order_id)) {
                    $currentUser = Auth::id();
                    
                    $getCurrentOrder = OrderDetail::where([
                        ['reference_id','=', $request->order_id],
                        ['user_id','=', $currentUser]
                    ])->first();
                    
                    if(!empty($getCurrentOrder) && $getCurrentOrder->state_id == OrderDetail::STATE_PENDING) {
                        
                        $cancelOrder = $getCurrentOrder->update([
                            'state_id' => OrderDetail::STATE_CANCEL,
                            'cancel_id' => $request->reason_id
                        ]);
                        
                        $getBookings = Booking::where('reference_id',$request->order_id)->update([
                            'state_id' => Booking::STATE_CANCELLED,
                            'cancel_id' => $request->reason_id
                        ]);
                        
                        if($cancelOrder) {
                            return response([
                                'message' => 'Success, Your booking has been Cancelled'
                            ], 200);
                        } else {
                            return response([
                                'message' => 'Unexpected error occured'
                            ], 400);
                        }
                    } else {
                        return response([
                            'message' => 'Order is already cancelled'
                        ], 400);
                    }
                }
                
            } else {
                return response([
                    'message' => 'Reason is not defined'
                ], 400);
            }
            
        }
        
        if(!empty($request->reason_message)) {
            
            if(!empty($request->order_id)) {
                $currentUser = Auth::id();
                
                $getCurrentOrder = OrderDetail::where([
                    ['reference_id','=', $request->order_id],
                    ['user_id','=', $currentUser]
                ])->first();
                
                if(!empty($getCurrentOrder) && $getCurrentOrder->state_id == OrderDetail::STATE_PENDING) {
                    
                    $cancelOrder = $getCurrentOrder->update([
                        'state_id' => OrderDetail::STATE_CANCEL,
                        'cancel_message' => $request->reason_message
                    ]);
                    
                    $getBookings = Booking::where('reference_id',$request->order_id)->update([
                        'state_id' => Booking::STATE_CANCELLED,
                        'cancel_message' => $request->reason_message
                    ]);
                    
                    if($cancelOrder) {
                        return response([
                            'message' => 'Success, Your booking has been Cancelled'
                        ], 200);
                    } else {
                        return response([
                            'message' => 'Unexpected error occurred'
                        ], 400);
                    }
                } else {
                    return response([
                        'message' => 'Order is already cancelled'
                    ], 400);
                }
            }
        }
    }
    
    /**
     * @OA\Post(
     *      path="/booking/service/delete",
     *      operationId="deleteBooking",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *     @OA\Parameter(
     *     name="booking_id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     ),
     *   ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Profile  Updated successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    
    public function delete(Request $request)
    {
        $booking = Booking::where('id',$request->booking_id)->first();
        
        if($booking)
        {
            
            if ($booking->delete())
            {
                return response([
                    'message' => 'Success, Your booking has been Deleted'
                ], 200);
            }
            else
            {
                return response([
                    'message' => 'unexpected error occurred'
                ], 404);
            }
        }
        else
        {
            return response([
                'message' => 'Booking does not exist'
            ], 200);
        }
    }
    
    /**
     * @OA\Get(
     *      path="/bookings",
     *      operationId="getBookingList",
     *      tags={"favourite"},
     *      summary="Get list of booking",
     *      description="Returns list of bookings",
     *     @OA\Parameter(
     *     name="user_id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     ),
     *   ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *      ),
     *       @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    
    
    public function bookings($user_id)
    {
        $booking = Booking::where(['user_id' => $user_id]);
        if ($booking->isNotEmpty()) {
            return response($booking);
        } else {
            return response(['message' => 'Not found'], 400);
        }
    }
    
    /**
     * @OA\Get(
     *      path="/booking/slots",
     *      operationId="bookingSlots",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *   @OA\Parameter(
     *     name="date",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="string",
     *       example="2022-12-13"
     *     ),
     *   ),
     *    @OA\Parameter(
     *     name="start_time",
     *     in="query",
     *     @OA\Schema(
     *       type="string",
     *       example="14:00"
     *     ),
     *   ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="time_start", type="integer", example="11:00"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function slots(Request $request) {
        if(!empty($request->date)) {
            
            if($request->start_time) {
                if($request->start_time < '08:00') {
                    $startTime = '08:00';
                } else {
                    $startTime = $request->start_time;
                }
            } else {
                $startTime = '08:00';
            }
            
            
            $endTime = '20:00';
            $interval = '60 minutes';
            $period = new CarbonPeriod($startTime, $interval, $endTime);
            $slots = [];
            
            foreach($period as $item){
                array_push($slots,$item->format("H:i"));
            }
            
            return response()->json([
                'list' => $slots,
                'message' => 'Slots'
            ], 200);
            
            
        } else {
            return response([
                'message' => 'unexpected error occurred'
            ], 400);
        }
    }
    
    /**
     *
     * @OA\Post(
     *      path="/booking/custom-request",
     *      operationId="customRequest",
     *      tags={"booking"},
     *      summary="",
     *      @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"images[]","name","description"},
     *                  @OA\Property(property="name", type="string", example="Paint"),
     *                  @OA\Property(property="description", type="string", example="Paint rooms"),  
     *                  @OA\Property(description="Add files to upload", property="images[]",type="array", @OA\Items(type="file",format="binary")),
     *           ),
     *       ),
     *   ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Provider Detail",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="name", type="string", example="provider one"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function customRequest(Request $request) {
        
        $validator = validator($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        
        if ($validator->fails())
        {
            
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        
        if(empty($_FILES['images'])) {
            return response()->json(['Please upload atleast one image'], 400);
        }
        
        $serviceName = $request->name;
        $serviceDesc = $request->description;
        $currentUser = Auth::user()->id;
        
        $customReq = new CustomReq();
        $customReq->name = $serviceName;
        $customReq->user_id = $currentUser;
        $customReq->desc = $serviceDesc;
        
        if($customReq->save()) {
            
            $customID = $customReq->id;
            
            $extensions = ['jpg','png','jpeg'];
            
            foreach($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $image_name = $_FILES["images"]["name"][$key];
                $image_name = str_replace(" ", "_", $image_name);
                $image_tmp = $_FILES["images"]["tmp_name"][$key];
                $image_ext = pathinfo($image_name,PATHINFO_EXTENSION);
                
                if(in_array($image_ext,$extensions)) {
                    $newName = time().'_'.$image_name;
                    
                    move_uploaded_file($image_tmp,'public/uploads/'.$newName);
                    
                    $saveFile = new CustomReqFiles();
                    $saveFile->user_id = $currentUser;
                    $saveFile->custom_req_id = $customID;
                    $saveFile->image = $newName;
                   
                    
                    if(!($saveFile->save())) {
                        return response([
                            "status" => 400,
                            'message' => 'Something Went Wrong'
                        ]);
                    }
                    
                } else {
                    return response()->json(['Only jpg,png,jpeg files are allowed'], 400);
                }
            }
            
            return response([
                "status" => 200,
                'message' => 'Custom Request submitted successfully'
            ]);
        } else {
            return response([
                "status" => 400,
                'message' => 'Something Went Wrong'
            ]);
        }
        
    }
    
    /**
     * @OA\Get(
     *      path="/booking/request-detail",
     *      operationId="requestDetail",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *   @OA\Parameter(
     *     name="request_id",
     *     in="query",
     *     @OA\Schema(
     *       type="integer",
     *       example="1"
     *     ),
     *   ),
     *   
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="req_name", type="string", example="Request Name"),
     *           @OA\Property(property="req_desc", type="string", example="Request Description"),
     *           @OA\Property(property="req_user", type="integer", example="33"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function requestDetail(Request $request) {
        
        $currentUser = Auth::user()->id;
        
        if(!empty($request->request_id)) {
            $requestID = $request->request_id;
            
            
            $getCustomRequest = CustomReq::where([
                ["id","=",$requestID],
                ["user_id","=",$currentUser],
            ])->first();
            
            if(!empty($getCustomRequest)) {
                return response([
                    "status" => 200,
                    "detail" => $getCustomRequest
                ]);
            } else {
                return response([
                    "status" => 400,
                    'message' => 'No request Found'
                ]);
            }
        } else {
            $getCustomRequests = CustomReq::where("user_id",$currentUser)->get();
            
            if(!empty($getCustomRequests)) {
                return response([
                    "status" => 200,
                    "list" => $getCustomRequests
                ]);
            } else {
                return response([
                    "status" => 400,
                    'message' => 'No requests Found'
                ]);
            }
        }
            
    }
    
    /**
     * @OA\Get(
     *      path="/booking/request-cancel",
     *      operationId="requestCancel",
     *      tags={"booking"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *   @OA\Parameter(
     *     name="request_id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="integer",
     *       example="1"
     *     ),
     *   ),
     *
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Request Cancel",
     *           @OA\JsonContent(
     *           @OA\Property(property="message", type="string", example="Request Cancelled Successfully"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function requestCancel(Request $request) {
        $validator = validator($request->all(), [
            'request_id' => 'required|integer',
        ]);
        
        if ($validator->fails())
        {
            
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        
        $currentUser = Auth::user()->id;
        
        $requestID = $request->request_id;
        
        $getCustomRequest = CustomReq::where([
            ["id","=",$requestID],
            ["user_id","=",$currentUser],
        ])->first();
        
        if(!empty($getCustomRequest)) {
            if($getCustomRequest->state_id == CustomReq::STATE_PENDING) {
                $getCustomRequest->update([
                    'state_id' => CustomReq::STATE_CANCELLED,
                ]);
                
                return response([
                    "status" => 200,
                    "message" => "Request cancelled successfully!!"
                ]);
                
            } else {
                return response([
                    "status" => 400,
                    'message' => 'You are not allowed to cancel the request now'
                ]);
            }
        } else {
            return response([
                "status" => 400,
                'message' => 'Something went wrong'
            ]);
        }
    }
    
}