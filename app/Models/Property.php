<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $table = 'properties';

    // price type
    const PRICE_TYPE = 0;

    const PRICE_TYPE_YEARLY = 1;

    const PRICE_TYPE_FULL = 2;

    // property state
    const STATE_PENDING = 1;

    const STATE_BOOKED = 2;

    // property type
    const PROPERTY_TYPE_HOUSE = 0;

    const PROPERTY_TYPE_BASEMENT = 1;

    const PROPERTY_TYPE_APPARTMENT = 2;

    public $appends = ['property_id_proof_1_url', 'property_id_proof_2_url', 'property_images_url', 'property_amanities_image'];

    protected $fillable = [
        'name',
        'no_of_rooms',
        'no_of_beds',
        'about',
        'price',
        'price_type',
        'address',
        'latitude',
        'longitude',
        'bathrooms',
        'property_type',
        'adult',
        'children',
        'infants',
        'town',
        'zipcode',
        'country',
        'property_id_proof_1',
        'property_id_proof_2',
        'created_by_id'
    ];

    public function propertyAmenities()
    {
        return $this->hasMany(PropertyAmenity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function getPropertyIdProof1UrlAttribute()
    {
        if ($this->property_id_proof_1) {
            return asset('public/uploads/property/propertyIds/' . $this->property_id_proof_1);
        }
        return null;
    }

    public function getPropertyIdProof2UrlAttribute()
    {
        if ($this->property_id_proof_2) {
            return asset('public/uploads/property/propertyIds/' . $this->property_id_proof_2);
        }
        return null;
    }

    public function getPropertyImagesUrlAttribute()
    {
        return $this->images->map(function ($image) {
            return asset('public/uploads/property/propertyImages/' . $image->image);
        });
    }

    public function getPropertyAmanitiesImageAttribute()
    {
        return $this->propertyAmenities->map(function ($amenity) {
            return $amenity->amenity ? asset('public/assets/amanities/' . $amenity->amenity->image) : null;
        });
    }
}
