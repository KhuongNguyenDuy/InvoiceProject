<?php

namespace App\Exports;

use App\Models\project;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
class ProjectExport implements FromView, WithEvents
{
    var $id;
    public function __construct(int $id) {
    	$this->id = $id;
    }
    public function registerEvents(): array
    {
        return [
            // AfterSheet::class    => function(AfterSheet $event) {
            //     $name_v = 'E3';
            //     $address_v = 'E4';
            //     $phone_v = 'E5'; 
            //     $title_v = 'C7'; 
            //     $size = 'C9:J30';
            //     $event->sheet->getDelegate()->getStyle($name_v)->getFont()->setName('MS PMincho')->setSize(14);
            //     $event->sheet->getDelegate()->getStyle($address_v)->getFont()->setName('MS PMincho')->setSize(10);
            //     $event->sheet->getDelegate()->getStyle($phone_v)->getFont()->setName('MS PMincho')->setSize(11);
            //     $event->sheet->getDelegate()->getStyle($title_v)->getFont()->setName('MS PMincho')->setSize(20);
            //     $event->sheet->getDelegate()->getStyle($size)->getFont()->setName('MS PMincho')->setSize(10);
          
               
            // },
            
                AfterSheet::class    => function(AfterSheet $event) {
                    $event->sheet->getStyle('B3:E3')->applyFromArray([
                        'font' => ['bold' => true]
                    ]);
                },
            
        ];
    }
    public function view(): View
    {
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
              ->where('invoice.id','=',$this->id)
              ->get();
            return view('admin.export_invoice', ['invoice_details' => $invoice_details]);
    }

}
