<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';
    
    const ADDRESS_HOME = 0;
    const ADDRESS_OFFICE = 1;
    const ADDRESS_OTHER = 2;
    
    protected $fillable = [
        'user_id',
        'address',
        'address_two',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'address_type'
        ];
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }  
}
