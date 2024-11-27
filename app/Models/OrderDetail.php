<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\BookService\Entities\Booking;
use Modules\Services\Entities\Coupon;

class OrderDetail extends Model
{
    use HasFactory;
    
    protected $table = 'order_detail';
    
    protected $fillable = [
        'reference_id',
        'state_id',
        'cancel_id',
        'cancel_message'
    ];
    
    
    const STATE_PENDING  = 0;
    const STATE_CONFIRM   = 1;
    const STATE_COMPLETE  = 2;
    const STATE_CANCEL = 3;
    
    public $appends = ['bookings_detail','sub_total','discount','total_amount','coupon_detail'];
    
    public function getBookingsDetailAttribute() {
        $getBookings = Booking::where('reference_id',$this->reference_id)->with(['bookingAddon','getService','Address','coupon','event','serviceProvider','bookingSubServices'])->get();
        return $getBookings;
    }
    
    public function getSubTotalAttribute() {
        $getBookings = Booking::where('reference_id',$this->reference_id)->get();
        $subTotal = 0;
        foreach($getBookings as $getBooking) {
            $subTotal += $getBooking->sub_total;
        }
        
        return $subTotal;
    }
    
    public function getDiscountAttribute() {
        $getBookings = Booking::where('reference_id',$this->reference_id)->get();
        $discounts = [];
        
        foreach($getBookings as $getBooking) {
            if($getBooking->coupon_id) {
                $getCouponPrice = Coupon::where('id',$getBooking->coupon_id)->pluck('amount')->first();
                $discounts[] = $getCouponPrice;
            } else if($getBooking->promo_amount) {
                $discounts[] = $getBooking->promo_amount;
            } else {
                $discounts[] = 0; 
            }
        }
        
        $discount = array_unique($discounts);
        return isset($discount[0]) ? $discount[0] : 0;
    }
    
    public function getTotalAmountAttribute() {
        $getBookings = Booking::where('reference_id',$this->reference_id)->get();
        $subTotal = 0;
        $discounts = [];
        foreach($getBookings as $getBooking) {
            $subTotal += $getBooking->sub_total;
            if($getBooking->coupon_id) {
                $getCouponPrice = Coupon::where('id',$getBooking->coupon_id)->pluck('amount')->first();
                $discounts[] = $getCouponPrice;
            } else if($getBooking->promo_amount) {
                $discounts[] = $getBooking->promo_amount;
            } else {
                $discounts[] = 0;
            }
        }
        
        $discount = array_unique($discounts);
        $totalAmount = $subTotal - (isset($discount[0]) ? $discount[0] : 0);
        return $totalAmount;
    }
    
    public function getCouponDetailAttribute() {
        $getBookings = Booking::where('reference_id',$this->reference_id)->get();
        $discounts = [];
        foreach($getBookings as $getBooking) {
            if($getBooking->coupon_id) {
                $getCouponPrice = Coupon::where('id',$getBooking->coupon_id)->first();
                $discounts[] = $getCouponPrice;
            } else if($getBooking->promo_amount) {
                $discounts[] = Coupon::where('amount',$getBooking->promo_amount)->first();
            } else {
                $discounts[] = null;
            }
        }
        
        $noCoupon = ['No Coupon Found'];
        
        $discount = array_unique($discounts);
        return isset($discount[0]) ? $discount[0] : null;
        
    }
    
}
