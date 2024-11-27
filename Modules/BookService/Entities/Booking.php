<?php

namespace Modules\BookService\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Modules\Smtp\Entities\EmailQueue;
use Modules\Services\Entities\Service;
use App\Models\BookingAddon;
use Modules\Services\Entities\Category;
use App\Models\Address;
use Modules\Services\Entities\Coupon;
use App\Models\Event;
use Modules\Services\Entities\AddOnService;
use App\Models\User;
use Modules\ServiceProvider\Entities\ServiceProvider;
use Modules\Services\Entities\BookingSubService;
use Modules\Services\Entities\SubService;
use App\Models\OrderDetail;


class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    protected $fillable = ['state_id','service_provider','cancel_id','cancel_message','promo_amount'];
    
    const TYPE_SERVICE = 1;
    const TYPE_EVENT = 2;

    
    const STATE_PENDING = 0;
    const STATE_CONFIRMED = 1;
    const STATE_CANCELLED = 3;
    const STATE_COMPLETE = 2;
    const STATE_DRAFT = 4;
    
    public $appends = ['total_price','add_on_data', 'sub_service_data','sub_total'];

    public function service()
    {
        $this->hasMany(Service::class);
    }
    
    public function serviceProvider() {
       return $this->belongsTo(ServiceProvider::class, 'service_provider');
    }

    public function getService()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    
    public function address() {
        return $this->belongsTo(Address::class, 'address_id');
    }
    
    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }
    
    public function coupon() {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
    
    public function bookingAddon() {
        return $this->hasMany(BookingAddon::class, 'booking_id');
    }
    
    public function bookingSubServices() {
        return $this->hasMany(BookingSubService::class, 'booking_id');
    }
    
    public function order() {
        return $this->belongsTo(OrderDetail::class, 'reference_id');
    }
    
    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sendBookingMailToUser()
    {
        $subject = "Booking Confirmed".Auth::User()->name;
        EmailQueue::create([
            'to_email' => Auth::user()->email,
            'subject' => $subject,
            'message' => 'Booking Confirmed',
            'type_id' => EmailQueue::TYPE_KEEP_AFTER_SEND
        ]);
    }
    
    public static function boot() {
         parent::boot();
         self::deleting(function($subCategory) { // before delete() method call this
             $subCategory->bookingAddon()->each(function($subCategory) {
                 $subCategory->delete(); // <-- direct deletion
             });
         });
     }
     
     public function getSubTotalAttribute() {
         if(!empty($this->event_id)) {
             $eventPrice = Event::where('id',$this->event_id)->pluck('price')->first();
             return $eventPrice;
         } else {
             if(!empty($this->service_id)) {
                 $servicePrice = Service::where('id',$this->service_id)->pluck('price')->first();
                 
                 if(!empty($servicePrice)) {
                     $servicePrice = $servicePrice;
                 } else {
                     $servicePrice = 0;
                 }
                 
                 $totalSub = 0;
                 
                 $subServices = BookingSubService::where('booking_id', $this->id)->get();
                 
                 if(!empty($subServices)) {
                     foreach($subServices as $subService) {
                         $subServicePrice = SubService::where('id', $subService->sub_service_id)->pluck('sub_service_price')->first();
                         $subServiceQty = $subService->quantity;
                         $finalSub = $subServicePrice * $subServiceQty;
                         $totalSub += $finalSub;
                     }
                 }
                 
                 $servicePrice = $servicePrice + $totalSub;
                 
                 $addOns = BookingAddon::where('booking_id', $this->id)->get();
                 
                 if(!empty($addOns)) {
                     $addOnPrices = 0;
                     foreach($addOns as $addOn) {
                         $addOnPrice = AddOnService::where('id',$addOn->addon_id)->pluck('price')->first();
                         $addQty = $addOn->quantity;
                         $finalPrice = $addOnPrice * $addQty;
                         $addOnPrices += $finalPrice;
                     }
                     $totalService = $servicePrice + $addOnPrices;
                     return $totalService;
                 } else {
                     return $servicePrice;
                 }
             }
         }
     }
    
     
     public function getTotalPriceAttribute(){
         if(!empty($this->coupon_id)) {
             $getCouponPrice = Coupon::where('id',$this->coupon_id)->pluck('amount')->first();
         } else {
             $getCouponPrice = 0;
         }
         
         if(!empty($this->event_id)) {
             $eventPrice = Event::where('id',$this->event_id)->pluck('price')->first();
             return $eventPrice-$getCouponPrice;
         } else {
             if(!empty($this->service_id)) {
                 $servicePrice = Service::where('id',$this->service_id)->pluck('price')->first();
                 
                 if(!empty($servicePrice)) {
                     $servicePrice = $servicePrice;
                 } else {
                     $servicePrice = 0;
                 }
                 
                 $totalSub = 0;
                 
                 $subServices = BookingSubService::where('booking_id', $this->id)->get();
                 
                 if(!empty($subServices)) {
                     foreach($subServices as $subService) {
                         $subServicePrice = SubService::where('id', $subService->sub_service_id)->pluck('sub_service_price')->first();
                         $subServiceQty = $subService->quantity;
                         $finalSub = $subServicePrice * $subServiceQty;
                         $totalSub += $finalSub;
                     }
                 }
                 
                 $servicePrice = $servicePrice + $totalSub;
                 
                 $addOns = BookingAddon::where('booking_id', $this->id)->get();
                 
                 if(!empty($addOns)) {
                     $addOnPrices = 0;
                     foreach($addOns as $addOn) {
                         $addOnPrice = AddOnService::where('id',$addOn->addon_id)->pluck('price')->first();
                         $addQty = $addOn->quantity;
                         $finalPrice = $addOnPrice * $addQty;
                         $addOnPrices += $finalPrice;
                     }
                     $totalService = $servicePrice + $addOnPrices-$getCouponPrice;
                     return $totalService;
                 } else {
                     return $servicePrice-$getCouponPrice;
                 }
             }
         }
     }
     
     public function getAddOnDataAttribute() {
         
         $addOns = BookingAddon::where('booking_id', $this->id)->get();
         
         if(!empty($addOns)) {
             $addArray = [];
             $count = 0;
             foreach($addOns as $addOn) {
                 $addOnDetail = AddOnService::where('id',$addOn->addon_id)->first();
                 $addArray[$count]['booking_detail'] = $addOnDetail;
                 $addArray[$count]['add_on_qty'] = $addOn->quantity;
                 $addArray[$count]['total_price'] = $addOn->quantity * $addOnDetail->price;
                 $count++;
             }
             return $addArray;
         }
     }
     
     public function getSubServiceDataAttribute() {
         $subServices = BookingSubService::where('booking_id',$this->id)->get();
         
         if(!empty($subServices)) {
             $subArray = [];
             $count = 0;
             foreach($subServices as $subService) {
                 $subDetail = SubService::where('id',$subService->sub_service_id)->first();
                 $subArray[$count]['sub_service_detail'] = $subDetail;
                 $subArray[$count]['sub_service_qty'] = $subService->quantity;
                 $subArray[$count]['total_price'] = $subService->quantity * $subDetail->sub_service_price;
                 $count++;
             }
             
             return $subArray;
         }
     }
     

}
