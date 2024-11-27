<?php

namespace Modules\Logger\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Logger extends Model
{
    use HasFactory;
    
    protected $table= 'error_logs';
  
}
