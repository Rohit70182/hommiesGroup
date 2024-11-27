<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDeviceToken extends Model
{
    use HasFactory;
    protected $table = "user_device_tokens";
}
