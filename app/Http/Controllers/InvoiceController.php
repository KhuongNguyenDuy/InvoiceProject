<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index2(){
        $invoices = invoice::paginate(5);
        return view('admin.invoice') -> with('invoices',$invoices);
        //return view('admin.project',['projects' => $projects]); 
        //return view('admin.invoice');
    }
    public function index(){
        //$items = item::all();
        //$items = item::Paginate(10);
        invoice::Paginate(10);
         $invoices = DB::table('invoice')
              ->join('customer', 'invoice.customer_id', '=', 'customer.id')
              ->select('invoice.*','customer.name as customer_name','customer.adress as customer_address','customer.phone as customer_phone')
              ->orderBy('invoice.id', 'ASC')
              ->Paginate(10);
        return view('admin.invoice', ['invoices' => $invoices]);
        
     }
     public function show_invoice_detail($invoice_id){
        $invoice_details = DB::table('invoice')
              ->join('invoice_detail', 'invoice.id', '=', 'invoice_detail.invoice_id')
              ->join('customer', 'invoice.customer_id', '=', 'customer.id')
              ->join('item', 'item.id', '=', 'invoice_detail.item_id')
              ->join('project', 'item.project_id', '=', 'project.id')
              ->select(
                    'invoice.id','invoice.create_date','invoice.status','customer.name as customer_name',
                    'customer.adress as customer_address','customer.phone as customer_phone',
                    'customer.fax as customer_fax','invoice.estimate_id','invoice.expire_date',
                    'item.name as item_name','invoice_detail.quantity','invoice_detail.price',
                    'invoice_detail.amount','project.name as project_name'
                     )
              ->where('invoice.id','=',$invoice_id)
              ->get();
            return view('admin.invoice_detail', ['invoice_details' => $invoice_details]);
     }
     public function add_invoice(){
         $customers = DB::table('customer')->get();
         $projects = DB::table('project')->get();
         $estimates = DB::table('estimate')->get();
        return view('admin.add_invoice',[
            'customers' => $customers,
            'projects' => $projects,
            'estimates' => $estimates
        ]);
        
     }
     public function create(Request $request){
        $id = $request->id;
        $customers = DB::table('customer')->where('id',$id)->get();
       // return view('admin.add_invoice',['customers' => $customers]);
        return response()->json(['success'=>true,'info' => $customers]);
     }
     public function getItem(Request $request){
        $project_id = $request->id;
        $items = DB::table('item')->where('project_id',$project_id)->get();
        $data = '<table class="table table-bordered table-hover" id="tab_logic">';
        $data .= ' <tr>
                        <th class="text-center">Tên sản phẩm</th>
                        <th class="text-center">Đơn giá</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-center">Thành tiền</th>
                    </tr>';
        foreach($items as $item){
            $data.='<tr>';
                $data.='<td>'.$item->name.'</td>';                
                $data.= '<td><input type="number" name="price[]" placeholder="Enter Unit Price" class="form-control price" step="0.00" min="0" value="'.$item->price.'" readonly/></td>';
                $data.= '<td><input type="number" id="soluong" name="soluong" placeholder="Enter Qty" class="form-control qty" step="0" min="0"/></td>';
                $data.='<td><input type="number" name="total[]" placeholder="0.00" class="form-control total" readonly/></td>';
            $data.='</tr>';
        }
        $data.= '</table>';
        echo $data;
 
     }
 
     public function store(Request $request)
     {
         $data = $request->all();
         return response()->json(['success'=>'Ajax request submitted successfully']);
     }
     
     
}

