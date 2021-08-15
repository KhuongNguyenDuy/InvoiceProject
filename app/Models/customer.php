<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers'; 
    public static function showAllCustomer(){
        $customers = DB::table('customers')->get();
        return $customers;
    }
    public static function showCustomerById($id){
        $customers = DB::table('customers')->where('id',$id)->get();
        return $customers;
    }
}
