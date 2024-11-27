<?php

namespace Modules\Favourite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuickLink extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    public static function getExploreOptions()
    {
        return [
            "INTERNAL",
            "EXTERNAL"
        ];
    }
    
    public function getExplore()
    {
        $list = self::getExploreOptions();
        return isset($list[$this->explore_option]) ? $list[$this->explore_option] : 'Not Defined';
    }
    
    const STATE_INACTIVE = 0;
    
    const STATE_ACTIVE = 1;
    
    const STATE_DELETED = 2;
    public static function getStateOptions()
    {
        return [
            self::STATE_INACTIVE => "New",
            self::STATE_ACTIVE => "Active",
            self::STATE_DELETED => "Deleted"
        ];
    }
    
    public function getState()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }
    public static function getQuickLinks()
    {
        $quick = QuickLink::find()->where([
            'state_id' => QuickLink::STATE_ACTIVE
        ]);
        $quick->limit = 10;
        $res = $quick->all();
        return $res;
    }
}
