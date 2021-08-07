<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    use HasFactory;
    protected $table = 'project';
    /**
     * Get the items for the project.
     */
    public function items()
    {
        return $this->hasMany( 'App\Models\item', 'project_id', 'id' );
    }
}
