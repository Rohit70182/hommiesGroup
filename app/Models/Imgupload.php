<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imgupload extends Model
{
    use HasFactory;
    protected $table='imguploads';
    protected $fillable=[
        'name',
        'image_path',
        'user_id',
    ];
    public function imgRelation(){
        //return $this->belongsTo(User::class);
      return $this->whereBelongsTo($user)->get();
    }
    }
