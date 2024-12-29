<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;
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
}
