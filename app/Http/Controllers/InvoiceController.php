<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PHPExcel_Style_Border;

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
     public function export($invoice_id,$type){
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
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('MS PMincho');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(0.27, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(0.64, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(4.0, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(6.0, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18.33, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(5.67, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(6.04, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(11.5, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(14.83, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(13.17, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(0.45, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(0.36, 'cm');

        $spreadsheet->getActiveSheet()->mergeCells('E3:K3')->setCellValue('E3', 'VAIX CO., LTD');
        $sheet->getStyle("E3")->getFont()->setBold(true)->setName('MS PMincho')->setSize(14);

        $sheet->setCellValue('E4','So 50, Go Soi, Hong Ky, Soc Son, Ha Noi, Viet Nam');
        
        $sheet->setCellValue('E5','Tel: +843-3384-6868');
        $sheet->getStyle("E5")->getFont()->setSize(11);
        $styleArray1 = [
            'font' => [
                'size' => 20,
                'bold' => true
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $styleArray2 = [
            'font' => [
                'bold' => true
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];
        $sheet->setCellValue('C9','日付：');
        $sheet->setCellValue('G9','No：');
        $sheet->setCellValue('C10','お客様：');
        $sheet->setCellValue('C11','住所：');
        $sheet->setCellValue('C12','TEL：');
        $sheet->setCellValue('C13','見積番号：');
        $sheet->setCellValue('C15','製品・サービス：');
        $sheet->setCellValue('G12','FAX：　');
        $spreadsheet->getActiveSheet()->getStyle('C7')->applyFromArray($styleArray1);
        $spreadsheet->getActiveSheet()->getStyle('C9:C15')->applyFromArray($styleArray2);
        $spreadsheet->getActiveSheet()->getStyle('E9:E15')->applyFromArray($styleArray2);
        $spreadsheet->getActiveSheet()->getStyle('G9')->applyFromArray($styleArray2);
        $spreadsheet->getActiveSheet()->getStyle('G12')->applyFromArray($styleArray2);
        $spreadsheet->getActiveSheet()->getStyle('H12')->applyFromArray($styleArray2);

        $spreadsheet->getActiveSheet()->mergeCells('C6:J6');
        $spreadsheet->getActiveSheet()->mergeCells('C7:J7')->setCellValue('C7','請求書');
        $spreadsheet->getActiveSheet()->mergeCells('E9:F9')->setCellValue('E9','todat');//today
        $spreadsheet->getActiveSheet()->mergeCells('E10:J10')->setCellValue('E10','name');//name
        $spreadsheet->getActiveSheet()->mergeCells('E11:J11')->setCellValue('E11','dia chi');//address
        $spreadsheet->getActiveSheet()->mergeCells('E12:F12')->setCellValue('E12','234567890');//phone
        $spreadsheet->getActiveSheet()->mergeCells('H12:I12')->setCellValue('H12','f23456789');//fax
        $spreadsheet->getActiveSheet()->mergeCells('E13:F13')->setCellValue('E13','345678');//estimate
        $spreadsheet->getActiveSheet()->mergeCells('I13:J13')->setCellValue('I13','');
        $spreadsheet->getActiveSheet()->mergeCells('E14:F14')->setCellValue('E14','');
        $spreadsheet->getActiveSheet()->mergeCells('I14:J14')->setCellValue('I14','');
        $spreadsheet->getActiveSheet()->mergeCells('E15:J15')->setCellValue('E15','Project 2');//project name

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $item_count = $invoice_details->count()+24;
        $sheet->getStyle('C18:J'.$item_count)->applyFromArray($styleArray);        
        $sheet->setCellValue('C18','#');
        $sheet->setCellValue('D18','項目');
        $sheet->setCellValue('E18','数量');
        $sheet->setCellValue('F18','単価（円）');
        $sheet->setCellValue('G18','合計（円）');
        $sheet->getStyle('C18:J18')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('C18:J18')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('C18:J18')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('C18:J18')->getAlignment()->setWrapText(true);
       // $spreadsheet->getActiveSheet()->getStyle('C18:J18')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $rows = 19;
        for ( $i = 0; $i < $invoice_details->count(); $i++ ) { 
            $sheet->setCellValue('C' . $rows, $i);
            $sheet->setCellValue('D' . $rows, $invoice_details[$i]->item_name);
            $sheet->setCellValue('E' . $rows, $invoice_details[$i]->quantity);
            $sheet->setCellValue('F' . $rows, $invoice_details[$i]->price);
            $sheet->setCellValue('G' . $rows, $invoice_details[$i]->amount);
        }
    
        // foreach($employees as $empDetails){
        //     $sheet->setCellValue('A' . $rows, $empDetails['id']);
        //     $sheet->setCellValue('B' . $rows, $empDetails['name']);
        //     $sheet->setCellValue('C' . $rows, $empDetails['age']);
        //     $sheet->setCellValue('D' . $rows, $empDetails['skills']);
        //     $sheet->setCellValue('E' . $rows, $empDetails['address']);
        //     $sheet->setCellValue('F' . $rows, $empDetails['designation']);
        //     $rows++;
        //     }
        //$spreadsheet->getActiveSheet()->getRowDimension('10')->setRowHeight(100, 'pt');
       
        

      
    
    



            $fileName = "emp.".$type;
            if($type == 'xlsx') {
                 $a = new Xlsx($spreadsheet);
            } else if($type == 'xls') {
                $a = new Xls($spreadsheet);
            }
            $a->save($fileName);
            header("Content-Type: application/vnd.ms-excel");
           // return redirect(url('/')."/invoice".$invoice_id);
    
     }
     
     
}
