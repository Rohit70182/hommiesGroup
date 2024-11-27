<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Services\Entities\Service;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';

    protected $fillable = [
        'title',
        'state_id',
        'type_id',
        'services'
    ];

    const STATE_INACTIVE = 0;

    const STATE_ACTIVE = 1;
    
    public $appends = ['event_services'];
    
    public function getStateAttribute()
    {
        switch ($this->state_id) {

            case self::STATE_INACTIVE:
                return "Inactive";
                break;
            case self::STATE_ACTIVE:
                return "Active";
                break;
            case self::STATE_DELETED:
                return "Deleted";
                break;
            default:
                return "Not Define";
        }
    }
    
    public function getEventServicesAttribute() {
        $service = $this->services;
        $explodeVal = explode(',', $service);
        $ary = [];
        foreach ($explodeVal as $expl)
        {
            $data = Service::find($expl);
            if($data){
                $ary[] = $data;
            }
        }
        return $ary;
    }


    public function getService()
    {
        $service = $this->services;
        $explodeVal = explode(',', $service);
        $ary = [];
        foreach ($explodeVal as $expl) 
        {
            $data = Service::find($expl);
            if($data){
                $ary[] = $data->name;                
            }
        }
        $implodeVal=implode(", ",$ary);
        echo $implodeVal;
    }
    
}

