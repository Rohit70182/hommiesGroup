<?php

namespace Modules\ServiceProvider\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookServiceProvider extends Model
{
    use HasFactory;
    protected $table = 'book_service_provider';
    
    protected $fillable = [
        'service_provider_id',
];
    
    protected static function newFactory()
    {
        
    }
}
