<?php

namespace Modules\Seo\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    protected $table = 'seo_analytics';

    const STATE_INACTIVE = 0;

    const STATE_ACTIVE = 1;

    const STATE_DELETED = 2;

    const TYPE_GOOGLE = 0;


    public $appends = ['state', 'type'];

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

    public function getTypeAttribute()
    {
        switch ($this->type_id) {
            case self::TYPE_GOOGLE:
                return "Google Analytics";
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
