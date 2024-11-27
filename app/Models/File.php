<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $table='files';

    protected $fillable=['name','size','key','model_type','model_id','type_id','created_by_id'];

}