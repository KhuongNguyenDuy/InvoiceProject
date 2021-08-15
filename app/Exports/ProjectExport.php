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
