<?php

namespace Modules\Services\Entities;

use Modules\Services\Entities\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use DB;

class Category extends Model
{
    use HasFactory;
    protected $table = 'service_categories';
    protected $fillable = [
        'name',
        'desc',
        
     ];

    public $appends = ['image_url'];
    
    const STATE_INACTIVE = 0;
    
    const STATE_ACTIVE = 1;
    
    const STATE_BANNED = 2;
    
    const STATE_DELETED = 3;
    
    const PAGINATE = 10;
    
    /**
     * Get the sub-category for the Category.
     */
    public function subcategory()
    {
        return $this->hasMany(SubCategory::class,'category_id');
    }
     
    public function service()
    {
      return $this->belongsTo(Service::class);
    }
     
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

    public function getImageUrlAttribute()
    {
        if($this->image){
            return asset('public/uploads/'.$this->image);
        } else {
            return null;
        }
    }

     
//      public static function boot() {
//          parent::boot();
//          self::deleting(function($subCategory) { // before delete() method call this
//              $subCategory->subcategory()->each(function($subCategory) {
//                  $subCategory->delete(); // <-- direct deletion
//              });
//          });
//      }
        
}
