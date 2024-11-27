<?php

namespace Modules\Services\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_categories';
    protected $fillable = [
        'name',
        'desc',
        'category_id',
        
     ];
    
    const STATE_INACTIVE = 0;
    
    const STATE_ACTIVE = 1;

     public function getCategory()
     {
        return $this->belongsTo(Category::class, 'category_id');
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
     
}
