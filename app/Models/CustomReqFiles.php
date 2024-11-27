<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomReqFiles extends Model
{
    use HasFactory;
    
    protected $table = 'custom_req_files';
    protected $fillable = ['user_id','custom_req_id','image'];
    
}
