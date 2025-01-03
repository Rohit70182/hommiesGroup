<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyHistory extends Model
{
    use HasFactory;

    const STATE_ACTIVE = 1;

    const SOLD_INSIDE_PLATFORM = 0;

    const SOLD_OUTSIDE_PLATFORM = 1;

    protected $table = 'property_history';

    protected $fillable = [
        'property_id',
        'to_user',
        'state_id',
        'message'
    ];

    public $timestamps = true;
}
