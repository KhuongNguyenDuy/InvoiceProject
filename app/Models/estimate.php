<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    use HasFactory;
    protected $table = 'estimates';
    public $incrementing = false;
    public static function showAllEstimate(){
        $estimates = DB::table('estimates')->get();
        return $estimates;
    }
}
