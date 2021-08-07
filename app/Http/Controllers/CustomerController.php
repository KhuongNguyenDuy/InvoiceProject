<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        $customers = customer::paginate(5);
        //return view('admin.project',['projects' => $projects]);
        return view('admin.customer') -> with('customers',$customers);
    }
}
