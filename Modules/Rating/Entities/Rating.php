<?php

namespace Modules\Rating\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    const STATE_DELETED = 0;
    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 2;

    protected $table = 'rating';

    public $appends = ['created_by_user'];

    protected $fillable = [
        'model_type',
        'model_id',
        'created_by_id',
        'state_id',
        'type_id',
        'title',
        'rating'
    ];

    public static function getStateOptions()
    {
        return [
            self::STATE_INACTIVE => "New",
            self::STATE_ACTIVE => "Active",
            self::STATE_DELETED => "Deleted"
        ];
    }
    public function getState()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }

    public function getUser()
    {
        return $this->belongsTO('App\Models\User', 'created_by_id', 'id');
    }
    public function getCreatedByUserAttribute()
    {
        return $this->getUser()->first();
    }
}
