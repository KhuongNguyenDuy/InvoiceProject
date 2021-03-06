<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'invoice_item';
    protected $primaryKey = ['invoice_id', 'item_id'];
    public $incrementing = false;
    protected $fillable = [
        'invoice_id', 'item_id', 'quantity', 'price', 'amount'
    ];

    //insert invoice detail
    public static function insert($invoiceDetail){
        DB::table('invoice_item')->insert($invoiceDetail);
    }
}
