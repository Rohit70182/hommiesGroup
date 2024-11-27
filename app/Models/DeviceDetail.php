<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceDetail extends Model
{
    use HasFactory;
    protected $table='device_details';
    Protected $fillable=['access_token','device_token','device_name','device_type','type_id','created_by_id'];
}
