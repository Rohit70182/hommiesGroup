<?php

namespace Modules\Services\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\BookService\Entities\Booking;

class BookingSubService extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $table = 'booking_sub_services';
    
    public function booking() {
        return $this->belongsTo(Booking::class, 'id' ,'booking_id');
    }
    
    public function subService() {
        return $this->belongsTo(SubService::class, 'id', 'sub_service_id');
    }
    
}
