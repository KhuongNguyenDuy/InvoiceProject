<?php

namespace App\Http\Controllers;
use App\Models\item;
use App\Models\project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    //
    public function index(){
       //$items = item::all();
       //$items = item::Paginate(10);
        item::Paginate(10);
        $items = DB::table('item')
             ->join('project', 'item.project_id', '=', 'project.id')
             ->select('item.id','item.name','item.price','project.name as project_id')
             ->orderBy('item.id', 'ASC')
             ->Paginate(10);
           // print_r($items);
       return view('admin.item', ['items' => $items]);
       
    }
    public function findItemByProjectID($id){
        $items = project::find($id)->items;
        return view('admin.item', ['items' => $items]);
        
     }
}

