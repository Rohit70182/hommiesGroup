<?php

namespace Modules\Services\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';

    
    const STATE_NEW = 3;
    
    const STATE_INACTIVE = 0;

    const STATE_ACTIVE = 1;
    
//     const STATE_ARCHIVE = 2;

    public $appends = ['state'];

    public function getStateAttribute()
    {
        switch ($this->state_id) {

            case self::STATE_NEW: 
                return "New";
                break;

            case self::STATE_ACTIVE:
                return "Active";
                break;


//             case self::STATE_ARCHIVE:
//                 return "Archived";
                

                break;
                
            default:
                return "Not Defined";
            
         }  
    }
    
    public static function getStateOptions($id = null)
    {
        $list = array(
            self::STATE_ACTIVE => "Active",
            self::STATE_INACTIVE => "Inactive",
//             self::STATE_ARCHIVE => "Archive"
        );
        if ($id === null)
            return $list;
            return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }
    
    public function getState()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }
    

}
