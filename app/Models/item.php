<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;

    protected $table = 'item'; //set table item for model item

    /**
     * Get the project that owns the item.
     */
    public function project(){
        return $this->belongsTo('app/Models/project');
    }
}
