<?php

namespace Modules\ServiceProvider\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProviderServices;

class ServiceProvider extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     * 
     */

    const GENDER_MALE = 1;

    const GENDER_FEMALE = 2;

    const STATE_ACTIVE = 1;
    
    const STATE_INACTIVE = 0;
    
    const STATE_NOT_FAVOURITE = 0;

    const STATE_FAVOURITE = 1;

    use HasFactory;
    protected $table = 'service_providers';

    public $appends = ['image_url', 'certification_url','services_data'];

    protected $fillable = [
        'name',
        'address',
        'experince',
        'contact',
        'image',
    ];
    
    public function getServicesDataAttribute() {
        $services = ProviderServices::where('service_provider_id',$this->id)->with('service')->get();
        
        return $services;
    }

    public function getGender()
    {
        switch ($this->gender) {
            case self::GENDER_MALE:
                return "Male";

            case self::GENDER_FEMALE:
                return "Female";
                break;

            default:
                return "Not Defined";
        }
    }

    public function getState()
    {
        switch ($this->state_id) {
            case self::STATE_ACTIVE:
                return "Active";

            case self::STATE_INACTIVE:
                return "Inactive";
                break;

            default:
                return "Not Defined";
        }
    }


    public function getImageUrlAttribute()
    {
        if($this->image){
            return asset('public/uploads/'.$this->image);
        } else {
            return null;
        }
    }

    public function getCertificationUrlAttribute()
    {
        if($this->image){
            return asset('public/uploads/'.$this->certifications);
        } else {
            return null;
        }
    }

}
