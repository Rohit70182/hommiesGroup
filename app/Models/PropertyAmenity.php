<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAmenity extends Model
{
    use HasFactory;

    protected $table = 'property_amenities';

    protected $fillable = [
        'property_id',
        'amenities_id',
        'state_id',
        'created_by_id',
        'created_on',
    ];

    // Define relationships
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function amenity()
    {
        return $this->belongsTo(Amenity::class, 'amenities_id');
    }
}