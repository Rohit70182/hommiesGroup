<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 0;
    const STATE_DELETED = 2;
    protected $table = 'amenities';

    public $appends = ['amanities_image'];

    protected $fillable = [
        'name',
        'image',
        'state_id',
        'created_by_id'
    ];

    public function getAmanitiesImageAttribute()
    {
        if ($this->image) {
            return asset('public/assets/amanities/' . $this->image);
        }
        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
    
    public static function getAmenityStatus($id = null)
    {
        $list = array(
            self::STATE_ACTIVE => "Active",
            self::STATE_INACTIVE => "Inactive",
            self::STATE_DELETED => "Deleted"
        );
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    public function getState()
    {
        $list = self::getAmenityStatus();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }
}
