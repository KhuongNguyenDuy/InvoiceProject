<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Customer;
use App\Models\Project;
use App\Models\Estimate;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;
use PHPExcel_Style_Border;
use DateTime;


class InvoiceController extends Controller
{
    /**
     * Get all invoice
     */
    public function index(){
        $invoices = Invoice::showAllInvoice();
        return view('admin.invoice', ['invoices' => $invoices]);
     }

     /**
     * Show invoice detail by invoice_id
     */
     public function showInvoiceDetail($invoice_id){
        $invoiceDetails = Invoice::showInvoiceDetail($invoice_id);
        return view('admin.invoice_detail', ['invoiceDetails' => $invoiceDetails]);
     }
     /**
      * get table customer, project, estimate, item
      * show in to form add invoice
     */
     public function showFormAddInvoice(Request $request){
         $customers = Customer::showAllCustomer();
         $projects = Project::showProjectById($request->project);
         $estimates = Estimate::showAllEstimate();
         $items = Item::showItemByProjectId($request->project);
         return view('admin.add_invoice',[
            'customers' => $customers,
            'projects' => $projects,
            'items' => $items,
            'estimates' => $estimates
        ]);
     }
     /**
      * get table customer, project, estimate, item
      * show in to form add invoice
     */
     public function addInvoice(Request $request){
         $invoiceID = 0; // 0: insert fail. >0: insert success
         DB::beginTransaction();
         try {
            $invoice = array(
                'create_date' => $request->ngaytao,
                'status' => false,
                'total' => (float)str_replace(",", "", $request->total_amount),
                'expire_date' => $request->hantt,
                'estimate_id' => $request->estimate,
                'customer_id' => $request->khachhang
            );
            //get id of invoice inserted
            $invoiceID = Invoice::insert($invoice);
            DB::commit();
            }
            catch (Exception $e) {
                DB::rollback();
            }
            if($invoiceID > 0){ //if insert success -> insert invoice detail
                $array_price = $request->price;
                $array_qty = $request->qty;
                $array_id = $request->id;
                $array_total = $request->total;
                foreach ($array_id as $id => $key) { //convert to array with key and value
                    $result[$key] = array(
                        'price'  => (float)str_replace(",", "", $array_price[$id]),
                        'qty' => $array_qty[$id],
                        'total'  => (float)str_replace(",", "", $array_total[$id])
                    );
                }
                foreach($result as $key => $value){
                    if($value['qty'] > 0){
                        $invoiceDetail = array(
                            'invoice_id' => $invoiceID,
                            'item_id' => $key,
                            'quantity' => $value['qty'],
                            'price' => $value['price'],
                            'amount' => $value['total']
                        );
                        InvoiceDetail::insert($invoiceDetail);
                    }
                }
                return redirect('invoices')->with('success', 'Thêm hoá đơn thành công!'); //return redirect()->back()->with('success', 'Thêm hoá đơn thành công!');
            }
        }

    //  public function getItemByProjectId($id){
    //     $items = Item::showItemByProjectId($id);
    //     return view('admin.add_invoice', ['items' => $items]);
    //  }
    /**
     * find customer info by id customer
     */
    public function showCustomerInfo(Request $request){
        $customers = Customer::showCustomerById($request->id);
        return response()->json(['success'=>true,'info' => $customers]);
     }
  
     /**
      * export file excel: import exist file excel-> map data
      */
     public function exportInvoice($invoice_id){
         //get invoie detail from model
        $invoiceDetails = Invoice::showInvoiceDetail($invoice_id);
        $count = $invoiceDetails->count(); 
        $date = new DateTime($invoiceDetails[0]->create_date);
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('TrainingProject.xlsx');
        //remove worksheet Input
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Input')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);
        //set active sheet Invoice
        $spreadsheet->setActiveSheetIndexByName('Invoice');
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->getCell('E9')->setValue($date->format('Y/m/d'));
        $worksheet->getCell('E10')->setValue($invoiceDetails[0]->customer_name);
        $worksheet->getCell('E11')->setValue($invoiceDetails[0]->customer_address);
        $worksheet->getCell('E12')->setValue($invoiceDetails[0]->customer_phone);
        $worksheet->getCell('H12')->setValue($invoiceDetails[0]->customer_fax);
        $worksheet->setCellValueExplicit('E13',$invoiceDetails[0]->estimate_id,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $worksheet->getStyle('E13')->getNumberFormat()->setFormatCode("00000000000");
        $worksheet->getCell('E15')->setValue($invoiceDetails[0]->project_name);
        //table content list item
        if($count > 1){
            $worksheet->insertNewRowBefore(20, $count-1); //insert $count-1 row before row 20
        }
        $rows = 19;
        $sub_total = 0;
        $tax = config('global.tax'); //call file global- get tax
        for ( $i = 0; $i < $count; $i++ ) {
            $sub_total += $invoiceDetails[$i]->amount;
            $worksheet->mergeCells('D'.$rows.':G'.$rows);
            $worksheet->setCellValue('C' . $rows, $i+1);
            $worksheet->setCellValue('D' . $rows, $invoiceDetails[$i]->item_name);
            $worksheet->setCellValue('H' . $rows, ($invoiceDetails[$i]->quantity).'式');
            $worksheet->setCellValue('I' . $rows, $invoiceDetails[$i]->price);
            $worksheet->setCellValue('J' . $rows, $invoiceDetails[$i]->amount);
            $rows++;
        }
        $worksheet->setCellValue('C' . $rows, $i+1);
        $sub_tax = $sub_total * $tax / 100;
        $worksheet->setCellValue('J'.(22+$count),$sub_total);
        $worksheet->setCellValue('J'.(23+$count),$sub_tax);
        $worksheet->setCellValue('J'.(24+$count),($sub_tax+$sub_total));        
        $expire_date = new DateTime($invoiceDetails[0]->expire_date);
        $worksheet->getCell('E'.(30+$count))->setValue($expire_date->format('Y/m/d'));
        $worksheet->setCellValueExplicit('E'.(34+$count),"21410410265442",\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Invoice.xls"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
     }

    /**
      * export file excel 2
      * define create new file excel-> set format
      */
      public function exportInvoice2($invoice_id,$type){
        $invoice_details = DB::table('invoices')
        ->join('invoice_item', 'invoices.id', '=', 'invoice_item.invoice_id')
        ->join('customers', 'invoices.customer_id', '=', 'customers.id')
        ->join('items', 'items.id', '=', 'invoice_item.item_id')
        ->join('projects', 'items.project_id', '=', 'projects.id')
        ->select(
              'invoices.id','invoices.create_date','invoices.status','customers.name as customer_name',
              'customers.adress as customer_address','customers.phone as customer_phone',
              'customers.fax as customer_fax','invoices.estimate_id','invoices.expire_date',
              'items.name as item_name','invoice_item.quantity','invoice_item.price',
              'invoice_item.amount','projects.name as project_name'
               )
        ->where('invoices.id','=',$invoice_id)
        ->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $count = $invoice_details->count();
        $sheet->setShowGridlines(false); //hide gridline
        $sheet->setTitle("Invoice");//change name worksheet
        $sheet->getStyle('A1:K'.(40+$count))->getFont()->setName('MS PMincho')->setSize(10); //set font and font size
        /**
         * set column size and row size
         */
        $sheet->getColumnDimension('A')->setWidth(0.27, 'cm');
        $sheet->getColumnDimension('B')->setWidth(0.64, 'cm');
        $sheet->getColumnDimension('C')->setWidth(5.0, 'cm');
        $sheet->getColumnDimension('D')->setWidth(7.0, 'cm');
        $sheet->getColumnDimension('E')->setWidth(18.33, 'cm');
        $sheet->getColumnDimension('F')->setWidth(5.67, 'cm');
        $sheet->getColumnDimension('G')->setWidth(6.04, 'cm');
        $sheet->getColumnDimension('H')->setWidth(11.5, 'cm');
        $sheet->getColumnDimension('I')->setWidth(14.83, 'cm');
        $sheet->getColumnDimension('J')->setWidth(13.17, 'cm');
        $sheet->getColumnDimension('K')->setWidth(0.45, 'cm');
        $sheet->getColumnDimension('L')->setWidth(0.36, 'cm');
        $sheet->getRowDimension('1')->setRowHeight(15, 'pt');
        $sheet->getRowDimension('2')->setRowHeight(14, 'pt');
        $sheet->getRowDimension('3')->setRowHeight(17, 'pt');
        $sheet->getRowDimension('4')->setRowHeight(24, 'pt');
        $sheet->getRowDimension('5')->setRowHeight(15, 'pt');
        $sheet->getRowDimension('6')->setRowHeight(23, 'pt');
        $sheet->getRowDimension('7')->setRowHeight(23, 'pt');
        $sheet->getRowDimension('8')->setRowHeight(12, 'pt');
        for ($i = 9; $i <= 14; $i ++) {
            $sheet->getRowDimension($i)->setRowHeight(21);
        }
        $sheet->getRowDimension('15')->setRowHeight(15, 'pt');
        $sheet->getRowDimension('16')->setRowHeight(15, 'pt');
        $sheet->getRowDimension('17')->setRowHeight(6, 'pt');
        $row_index = 24 + $count;
        for ($i = 18; $i <= $row_index; $i ++) {
            $sheet->getRowDimension($i)->setRowHeight(28);
        }
        $sheet->getRowDimension('26')->setRowHeight(27, 'pt');
        $sheet->getRowDimension('27')->setRowHeight(27, 'pt');
        $sheet->getRowDimension('28')->setRowHeight(27, 'pt');
        $sheet->getRowDimension('29')->setRowHeight(9, 'pt');
        $sheet->getRowDimension('30')->setRowHeight(6, 'pt');
        $row_index2 = 35 + $count;
        for ($i = 31; $i <= $row_index2; $i ++) {
            $sheet->getRowDimension($i)->setRowHeight(18);
        }
        $sheet->getRowDimension('37')->setRowHeight(18, 'pt');
        $sheet->getRowDimension('38')->setRowHeight(20, 'pt');
        $sheet->getRowDimension('39')->setRowHeight(14, 'pt');
        $sheet->getRowDimension('40')->setRowHeight(15, 'pt');
        $sheet->getRowDimension('41')->setRowHeight(5.25, 'pt');

        /**
         *
         */
        $sheet->mergeCells('E3:K3')->setCellValue('E3', 'VAIX CO., LTD');
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
        $sheet->getStyle('C7')->applyFromArray($styleArray1);
        $sheet->getStyle('C9:C15')->applyFromArray($styleArray2);
        $sheet->getStyle('E9:E15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('G9')->applyFromArray($styleArray2);
        $sheet->getStyle('G12')->applyFromArray($styleArray2);

        $sheet->mergeCells('C6:J6');
        $sheet->mergeCells('C7:J7')->setCellValue('C7','請求書');
        $date = new DateTime($invoice_details[0]->create_date);
        $sheet->mergeCells('E9:F9')->setCellValue('E9',$date->format('Y-m-d'));//----today
        $sheet->mergeCells('E10:J10')->setCellValue('E10',$invoice_details[0]->customer_name);//name
        $sheet->mergeCells('E11:J11')->setCellValue('E11',$invoice_details[0]->customer_address);//address
        $sheet->mergeCells('E12:F12')->setCellValue('E12',$invoice_details[0]->customer_phone);//phone
        $sheet->mergeCells('H12:I12')->setCellValue('H12',$invoice_details[0]->customer_fax);//fax
        $sheet->mergeCells('E13:F13')->setCellValue('E13',$invoice_details[0]->estimate_id);//estimate
        $sheet->mergeCells('D18:G18');
        $sheet->mergeCells('I13:J13')->setCellValue('I13','');
        $sheet->mergeCells('E14:F14')->setCellValue('E14','');
        $sheet->mergeCells('I14:J14')->setCellValue('I14','');
        $sheet->mergeCells('E15:J15')->setCellValue('E15','Project 2');//project name

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->getStyle('C18:J'.($count+27))->applyFromArray($styleArray);
        $sheet->setCellValue('C18','#');
        $sheet->setCellValue('D18','項目');
        $sheet->setCellValue('H18','数量');
        $sheet->setCellValue('I18','単価（円）');
        $sheet->setCellValue('J18','合計（円）');
        $sheet->getStyle('C18:J18')->getFont()->setBold(true);
        $sheet->getStyle('C18:J'.($count+27))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('C18:J'.($count+27))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C18:J'.($count+27))->getAlignment()->setWrapText(true);

        $rows = 19;
        $sub_total = 0;
        $tax = config('global.tax'); //take tax in file global

        for ( $i = 0; $i < $count; $i++ ) {
            $sub_total += $invoice_details[$i]->amount;
            $spreadsheet->getActiveSheet()->mergeCells('D'.$rows.':G'.$rows);
            $sheet->setCellValue('C' . $rows, $i+1);
            $sheet->setCellValue('D' . $rows, $invoice_details[$i]->item_name);
            $sheet->setCellValue('H' . $rows, ($invoice_details[$i]->quantity).'式');
            $sheet->setCellValue('I' . $rows, $invoice_details[$i]->price);
            $sheet->setCellValue('J' . $rows, $invoice_details[$i]->amount);
            $rows++;
        }
        $sub_tax = $sub_total * $tax / 100;
        $sheet->setCellValue('C' . $rows,$invoice_details->count()+1);
        $sheet->getStyle('C'.$rows.':C'.($rows+$count))->getNumberFormat()->setFormatCode('0');
        $sheet->setCellValue('D' . $rows, '以上');
        $sheet->getStyle('D19:D'.($count+21))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->mergeCells('D'.$rows.':G'.$rows);
        $sheet->mergeCells('D'.($rows+1).':G'.($rows+1));
        $sheet->mergeCells('D'.($rows+2).':G'.($rows+2));
        $sheet->getStyle('I19:J'.($count+21))->getNumberFormat()->setFormatCode('_([$JPY] * #,##0_);_([$JPY] * (#,##0);_([$JPY] * "-"_);_(@_)');
        $sheet->getStyle('C'.(22+$count).':J'.(24+$count))->getFont()->setBold(true);
        $sheet->mergeCells('C'.(22+$count).':I'.(22+$count))->setCellValue('C'.(22+$count),'合計');
        $sheet->mergeCells('C'.(23+$count).':I'.(23+$count))->setCellValue('C'.(23+$count),'消費税('.$tax.'%)');
        $sheet->mergeCells('C'.(24+$count).':I'.(24+$count))->setCellValue('C'.(24+$count),'合計金額');
        $sheet->getStyle('C'.(22+$count).':'.'J'.(24+$count))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('J'.(22+$count).':J'.(24+$count))->getNumberFormat()->setFormatCode('_-[$¥-411]* #,##0_-;-[$¥-411]* #,##0_-;_-[$¥-411]* "-"_-;_-@_-');

        $sheet->setCellValue('J'.(22+$count),$sub_total);
        $sheet->setCellValue('J'.(23+$count),$sub_tax);
        $sheet->setCellValue('J'.(24+$count),($sub_tax+$sub_total));

        $sheet->mergeCells('C'.(25+$count).':J'.(27+$count))->setCellValue('C'.(25+$count),'備考');
        $sheet->getStyle('C'.(25+$count))->applyFromArray($styleArray2);
        $sheet->getStyle('C'.(25+$count))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

        $sheet->getStyle('C'.(30+$count).':C'.(35+$count))->applyFromArray($styleArray2);
        $sheet->getStyle('E'.(31+$count).':E'.(35+$count))->getFont()->setSize(11);
        $sheet->setCellValue('C'.(30+$count),'お支払い期限：');
        $sheet->setCellValue('C'.(31+$count),'銀行名：');
        $sheet->mergeCells('C'.(32+$count).':D'.(32+$count))->setCellValue('C'.(32+$count),'支店名：');
        $sheet->setCellValue('C'.(33+$count),'Swift コード：');
        $sheet->setCellValue('C'.(34+$count),'口座番号：');
        $sheet->setCellValue('C'.(35+$count),'口座名義：');
        $date = new DateTime($invoice_details[0]->expire_date);
        $sheet->mergeCells('E'.(30+$count).':F'.(30+$count))->setCellValue('E'.(30+$count),$date->format('Y-m-d'));
        $sheet->mergeCells('E'.(31+$count).':J'.(31+$count))->setCellValue('E'.(31+$count),'NGAN HANG TMCP DAU TU VA PHAT TRIEN VIET NAM (BIDV)');
        $sheet->mergeCells('E'.(32+$count).':I'.(32+$count))->setCellValue('E'.(32+$count),'DONG HA NOI');
        $sheet->setCellValue('E'.(33+$count),'BIDVVNVX');
        $sheet->mergeCells('E'.(34+$count).':I'.(34+$count))->setCellValue('E'.(34+$count),"21410410265442");

        $sheet->mergeCells('E'.(35+$count).':I'.(35+$count))->setCellValue('E'.(35+$count),'CONG TY TNHH TRI TUE NHAN TAO VAIX VIET NAM');
        $sheet->getStyle('E'.(30+$count).':'.'E'.(35+$count))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        /**
         * border outline
         */
        $styleborder = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('B2:K'.(39+$count))->applyFromArray($styleborder);


        /**
         * save file excel in to folder public
         */

        $date = date("Y-m-d h-i-sa");
        $fileName = "invoice-".$date.".".$type;
        if($type == 'xlsx') {
            $a = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $a = new Xls($spreadsheet);
        }
        $a->save($fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url("/invoice"));
     }

}







