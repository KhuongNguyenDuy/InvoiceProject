<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use Illuminate\Http\Request;

class EstimateController extends Controller
{
    public function index(){
        $estimates = Estimate::paginate(5);
        //return view('admin.project',['projects' => $projects]);
        return view('admin.estimate') -> with('estimates',$estimates);
    }
}
