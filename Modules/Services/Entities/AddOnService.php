<?php

namespace Modules\Services\Entities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOnService extends Model
{   
    const STATE_ACTIVE = 1;

    const STATE_INACTIVE = 0;
    
    
    use HasFactory;
    protected $table ='add_on_services';
    protected $fillable =[
        'name',
        'desc',
        'service_id',
        'price'
    ];
    
    
    public static function getStateOptions($id = null)
    {
        $list = array(
            self::STATE_ACTIVE => "Active",
            self::STATE_INACTIVE => "Inactive"
        );
        if ($id === null)
            return $list;
            return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }
    
    public function getService()
    {
        return $this->belongsTo(Service::class,'service_id');
    }
    
    public function getState()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }
    
    
    
}
