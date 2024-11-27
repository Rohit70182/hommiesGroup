<?php

namespace Modules\Services\Entities;

use Modules\Services\Entities\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\BookService\Entities\Booking;
use PhpParser\Node\Stmt\Static_;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 0;
    const STATE_INCOMPLETE = 2;
    const ZERO = 0;
    const TWO = 2;
    const EMPTY_PRICE = 0;
    const FREELANCER = 0;
    const COMPANY = 1;
    
    protected $fillable = [
        'name',
        'desc',
        'type'
    ];

    public $appends = ['image_url', 'service_addons','category','sub_category','minimum_sub_id','proper_price'];
    public $subMinServicePrice = ['sub_min_price'];
    public function getCategoryAttribute()
    {
        return Category::where('id',$this->category_id)->get();
    }

    public function getSubCategoryAttribute()
    {
        return SubCategory::where('id',$this->subcategory_id)->get();
    }

    public function getCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
    public function subServices() {

        return $this->hasMany(SubService::class,'service_id');

    }


    public function getSubCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    public static function getStateAttribute()
    {
        return [
            self::STATE_DISABLE => "Disabled",
            self::STATE_ENABLE => "Enabled"
        ];
    }

    public static function getServiceTypeAttribute()
    {
        return [
            self::FREELANCER => "Freelancer",
            self::COMPANY => "Company"
        ];
    }

    public function getState()
    {
        $list = self::getStateAttribute();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }

    public function getServiceType()
    {
        $list = self::getServiceTypeAttribute();
        return isset($list[$this->type]) ? $list[$this->type] : 'Not Defined';
    }
    
    public static function getStateOptions($id = null)
    {
        $list = array(
            self::STATE_ACTIVE => "Active",
            self::STATE_INACTIVE => "Inactive",
            self::STATE_INCOMPLETE => "Incomplete"
        );
        if ($id === null)
            return $list;
            return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }
    
    public function getStateid()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }
    
    
    public function booking()
    {
        $this->hasMany(Booking::class);
    }
    
    public function addon() {
        return $this->hasMany(AddOnService::class);
    }

    public function getImageUrlAttribute()
    {
        if($this->image){
            return asset('public/uploads/'.$this->image);
        } else {
            return null;
        }
    }
    
    public function getMinimumSubIdAttribute(){
        $getSub = SubService::where('service_id',$this->id)->orderBy('sub_service_price')->pluck('id')->first();    
        return $getSub;
    }
    
    public function getProperPriceAttribute() {
        
        $servicePrice = Service::where('id',$this->id)->pluck('price')->first();
        
        if($servicePrice > self::EMPTY_PRICE) {
            return $servicePrice;
        } else {
            $getSubPrice = SubService::where('service_id',$this->id)->orderBy('sub_service_price')->pluck('sub_service_price')->first();
            return $getSubPrice;
        }
        
    }
    
    public function getServiceAddonsAttribute()
    {
        return AddOnService::where('service_id', $this->id)->get();
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($check) {
            $check->subServices()->delete();
            $check->addon()->delete();
        });
    }
}
