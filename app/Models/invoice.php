<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $fillable = [
        'create_date', 'status', 'total', 'expire_date', 'estimate_id', 'customer_id'
    ];
    
}
