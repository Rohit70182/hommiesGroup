<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\BookService\Entities\Booking;

class BookingAddon extends Model
{
    use HasFactory;
    
    protected $table = 'booking_addon';
    
    protected $fillable = [
        'booking_id',
        'addon_id',
        'quantity',
        'type_id',
    ];
    
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
    
}
