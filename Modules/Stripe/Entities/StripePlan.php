<?php

namespace Modules\Stripe\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripePlan extends Model
{
    use HasFactory;

    const STATE_INACTIVE = 0;

    const STATE_ACTIVE = 1;

    const STATE_DELETED = 2;

    public $appends = ['state'];

    public function getStateAttribute()
    {
        switch ($this->state_id) {
            case self::STATE_INACTIVE:
                return "Inactive";
                break;
            case self::STATE_ACTIVE:
                return "Active";
                break;
            case self::STATE_DELETED:
                return "Deleted";
                break;
            default:
                return "Not Define";
        }
    }

    public function get_created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }
}
