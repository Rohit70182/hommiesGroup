<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table='notifications';
    protected $fillable=['title','description','model_id','is_read','state_id','type_id','model_type','to_user_id','created_by_id'];
}
