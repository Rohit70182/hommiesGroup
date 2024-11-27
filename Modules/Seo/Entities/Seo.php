<?php

namespace Modules\Seo\Entities;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $table = 'seo';

    const STATE_INACTIVE = 0;

    const STATE_ACTIVE = 1;
    

    public $appends = ['state'];

    public function getStateAttribute()
    {
        switch ($this->state_id) {
            case self::STATE_ACTIVE:
                return "Active";
                break;
            case self::STATE_INACTIVE:
                return "Inactive";
                break;
            default:
                return "Not Define";
        }
    }
}
