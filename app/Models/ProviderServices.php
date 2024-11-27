<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\ServiceProvider\Entities\ServiceProvider;
use Modules\Services\Entities\Service;

class ProviderServices extends Model
{
    
    use HasFactory;
    
    protected $table = 'provider_services';
    protected $fillable = ['service_provider_id','service_id'];   // here service provider id is come from users's table
    
    public $appends = ['service_data'];
    
    public function getServiceDataAttribute() {
        $serviceData = Service::where('id',$this->service_id)->get();
        return $serviceData;
    }
    
    
    public function serviceProvider() {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }
    
    public function service() {
        return $this->belongsTo(Service::class, 'services_id');
    }
}
