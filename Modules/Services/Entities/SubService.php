<?php

namespace Modules\Services\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubService extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $table = 'sub_services';
    

    const STATE_ACTIVE = 1;
    
    const STATE_INACTIVE = 0;
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function booking() {
        return $this->hasMany(BookingSubService::class, 'sub_service_id', 'id');
    }
    
}
