<?php

namespace Modules\Security\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blacklist extends Model
{
    use HasFactory;

    protected $table = 'security_blacklists';

    protected $fillable = [];
   
    const STATE_INACTIVE = 0;

    const STATE_ACTIVE = 1;

    const STATE_DELETED = 2;

    const TYPE_DENY = 0;

    Const TYPE_ALLOW = 1;
    
    public static function getStateAttribute()
    {
        return[
            self::STATE_INACTIVE => "Disabled",
            self::STATE_ACTIVE => "Enabled",
            self::STATE_DELETED => "Deleted",
        ];
    }
    public function getState()
    {
        $list=self::getStateAttribute();
        return isset($list[$this->state_id])  ? $list[$this->state_id] : 'Not Defined';
    }


    public static function getTypeAttribute()
    {
        return[
            self::TYPE_DENY => "Deny",
            self::TYPE_ALLOW => "Allow",
        ];
    }
    public function getType()
    {
        $list=self::getTypeAttribute();
        return isset($list[$this->type_id]) ? $list[$this->type_id] : 'Not Defined';
    }

    
}
