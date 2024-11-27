<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    
    const STATE_INACTIVE = 0;
    
    const STATE_ACTIVE = 1;
    
    const STATE_BANNED = 2;
    
    const STATE_DELETED = 3;
    
    const TERMS_CONDITION = 1;
    
    const PRIVACY_POLICY = 2;
    
    const ABOUT_US = 3;
    
    
    const PAGINATE = 10;
    
    
    protected $fillable = [
        'title',
        'description',
        'phone',
        'address',
        'latitude',
        'longitude',
        'state_id',
        'type_id',
        'created_by_id'
    ];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    
    public static function getTypeOptions()
    {
        return [
            self::PRIVACY_POLICY => "Privacy & Policy",
            self::TERMS_CONDITION => "Terms & Conditions",
            self::ABOUT_US => "About Us"
        ];
    }
    
    public static function getPageTitle($page)
    {
        $list = [
            'privacy-policy' => self::PRIVACY_POLICY,
            'terms-and-conditions' => self::TERMS_CONDITION,
            'about-us' => self::ABOUT_US
        ];
        return isset($list[$page]) ? $list[$page] : false;
    }
    
    public function getType()
    {
        $list = self::getTypeOptions();
        return isset($list[$this->type_id]) ? $list[$this->type_id] : 'Not Defined';
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
