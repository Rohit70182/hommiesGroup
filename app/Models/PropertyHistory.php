<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyHistory extends Model
{
    use HasFactory;

    const STATE_ACTIVE = 1;

    const SOLD_INSIDE_PLATFORM = 0;

    const SOLD_OUTSIDE_PLATFORM = 1;

    protected $table = 'property_history';

    protected $fillable = [
        'property_id',
        'to_user',
        'state_id',
        'message'
    ];

    public $timestamps = true;

    public static function getSoldPlatform($id = null)
    {
        $list = array(
            self::SOLD_INSIDE_PLATFORM => "Inside Platfrom",
            self::SOLD_OUTSIDE_PLATFORM => "Ouside Platform"
        );
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    public function getSold()
    {
        $list = self::getSoldPlatform();
        return isset($list[$this->sold_outside]) ? $list[$this->sold_outside] : 'Not Defined';
    }
}
