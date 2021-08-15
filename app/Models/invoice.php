<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $fillable = [
        'create_date', 'status', 'total', 'expire_date', 'estimate_id', 'customer_id'
    ];

    //show invoice detail by id
    public static function showInvoiceDetail($id){
        $invoiceDetails = DB::table('invoices')
              ->join('invoice_item', 'invoices.id', '=', 'invoice_item.invoice_id')
              ->join('customers', 'invoices.customer_id', '=', 'customers.id')
              ->join('items', 'items.id', '=', 'invoice_item.item_id')
              ->join('projects', 'items.project_id', '=', 'projects.id')
              ->select(
                    'invoices.id',
                    'invoices.create_date',
                    'invoices.status',
                    'customers.name as customer_name',
                    'customers.adress as customer_address',
                    'customers.phone as customer_phone',
                    'customers.fax as customer_fax',
                    'invoices.estimate_id',
                    'invoices.expire_date',
                    'items.name as item_name',
                    'invoice_item.quantity',
                    'items.price',
                    'invoice_item.amount',
                    'projects.name as project_name'
                     )
              ->where('invoices.id','=',$id)
              ->get();
              return $invoiceDetails;
    }

    //show all invoice
    public static function showAllInvoice(){
        $invoices = DB::table('invoices')
              ->join('customers', 'invoices.customer_id', '=', 'customers.id')
              ->select('invoices.*','customers.name as customer_name','customers.adress as customer_address','customers.phone as customer_phone')
              ->orderBy('invoices.id', 'ASC')
              ->Paginate(10);
        return $invoices;
    }
    //insert invoice
    public static function insert($invoice){
        $invoiceID = DB::table('invoices')->insertGetId($invoice);
        return $invoiceID;
    }
}
