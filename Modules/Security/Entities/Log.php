<?php

namespace Modules\Security\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;
    protected $table = 'security_logs';

    const STATE_ALLOWED = 0;

    const STATE_BANNED = 1;

    const TYPE_MOBILE = 1;

    const TYPE_DESKTOP = 0;

    protected $fillable = [];

    public static function getStateAttribute()
    {
        return [
            self::STATE_ALLOWED => "Allowed",
            self::STATE_BANNED => "Banned"
        ];
    }
    public function getState()
    {
        $list = self::getStateAttribute();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }
    public static function getTypeAttribute()
    {
        return[
            self::TYPE_MOBILE => "Mobile",
            self::TYPE_DESKTOP => "Desktop"
        ];
    }
    public function getType()
    {
     $list= self::getTypeAttribute();
     return isset($list[$this->type_id]) ? $list[$this->type_id] : 'Not Defined';   
    }
}
