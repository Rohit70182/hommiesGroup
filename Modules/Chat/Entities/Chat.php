<?php

namespace Modules\Chat\Entities;

use App\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Chat extends Model
{
    use HasFactory;

    const READ_NO = 0;
    const READ_YES = 1;

    const ADMIN_MESSAGE = 0;
    const USER_MESSAGE = 1;

    const ONLY_MESSAGE = 0;
    const ONLY_IMAGE = 1;
    const IMAGE_AND_MESSAGE = 2;

    protected $table = 'chats';

    public $appends = ['image', 'created_detail'];

    public function message()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageAttribute()
    {
        return asset('public/uploads/' . $this->file);
    }

    public function toId()
    {
        return $this->belongsTo('App\Models\User', 'to_id', $this->id);
    }
    

    public function getCreatedDetailAttribute()
    {
        $currentFormat = $this->created_at;

        $currentFormat = explode('T', $currentFormat);
        $date = $currentFormat[0];

        return $date;
    }

    public function fromId()
    {
        return $this->belongsTo('App\Models\User', 'from_id', $this->id);
    }

    // public function propertyId()
    // {
    //     return $this->belongsTo(Property::class, 'property_id', $this->property_id);
    // }
}
