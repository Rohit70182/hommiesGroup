<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    const STATE_DELETED = 0;
    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 2;

    protected $fillable = [];

    protected $table = 'comment';

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
    public static function getModelName()
    {
        return Request()->path();
    }
}
