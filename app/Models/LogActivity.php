<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    const ZERO = 0;
    
    const STATE_ACTIVE = 1;
    
    const STATE_INACTIVE = 0;
    
    protected $fillable = [
    'subject', 'url', 'method', 'ip', 'agent', 'user_id'

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
    
    public function getState()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }
    
}
