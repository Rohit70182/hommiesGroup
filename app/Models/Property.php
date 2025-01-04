<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Rating\Entities\Rating;

class Property extends Model
{
    use HasFactory;

    protected $table = 'properties';

    // price type
    const PRICE_TYPE_MONTHLY = 0;

    const PRICE_TYPE_YEARLY = 1;

    const PRICE_TYPE_FULL = 2;

    // property state
    const STATE_PENDING = 1;

    const STATE_SOLD = 2;

    const STATE_DELETED = 3;

    // property type
    const PROPERTY_TYPE_HOUSE = 0;

    const PROPERTY_TYPE_BASEMENT = 1;

    const PROPERTY_TYPE_APPARTMENT = 2;

    public $appends = ['property_id_proof_1_url', 'property_id_proof_2_url', 'property_images_url', 'property_amanities_image', 'testimonials'];

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
        'area',
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

    public function soldTo()
    {
        return $this->belongsTo(User::class, 'sold_to');
    }

    public function histories()
    {
        return $this->hasMany(PropertyHistory::class, 'property_id');
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

    public function getPropertyAmanitiesImgNameAttribute()
    {
        return $this->propertyAmenities->map(function ($amenity) {
            return [
                'image_url' => $amenity->amenity ? asset('public/assets/amanities/' . $amenity->amenity->image) : null,
                'name' => $amenity->amenity ? $amenity->amenity->name : 'Unknown Amenity',
            ];
        });
    }

    public function getTestimonialsAttribute()
    {
        return Rating::where('model_id', $this->id)
            ->where('model_type', get_class($this))
            ->get();
    }

    public static function getPriceType($id = null)
    {
        $list = array(
            self::PRICE_TYPE_MONTHLY => "Monthly",
            self::PRICE_TYPE_YEARLY => "Yearly",
            self::PRICE_TYPE_FULL => "Full",
        );
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    public function getPrice()
    {
        $list = self::getPriceType();
        return isset($list[$this->price_type]) ? $list[$this->price_type] : 'Not Defined';
    }

    public static function getPropertyStatus($id = null)
    {
        $list = array(
            self::STATE_PENDING => "Active",
            self::STATE_SOLD => "Sold",
            self::STATE_DELETED => "Deleted"
        );
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    public function getState()
    {
        $list = self::getPropertyStatus();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }

    public static function getPropertyType($id = null)
    {
        $list = array(
            self::PROPERTY_TYPE_HOUSE => "House",
            self::PROPERTY_TYPE_BASEMENT => "Basement",
            self::PROPERTY_TYPE_APPARTMENT => "Appartment"
        );
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    public function getType()
    {
        $list = self::getPropertyType();
        return isset($list[$this->property_type]) ? $list[$this->property_type] : 'Not Defined';
    }
}
