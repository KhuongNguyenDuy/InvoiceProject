<?php

namespace App\Http\Controllers;

use App\Exports\ProjectExport;
use App\Models\Project;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Gloudemans\Shoppingcart\Contracts\Buyable;
class ProjectController extends Controller
{
    //
    public function index(){
        $projects = Project::paginate(5);
        //return view('admin.project',['projects' => $projects]);
        return view('admin.project') -> with('projects',$projects);
    }
    public function destroy($id){
        $projects = Project::where('id',$id)->delete();
        return view('admin.project',['projects' => $projects]);
    }
    public function show(){
        $projects = Project::all();
        return view('admin.get_project',['projects' => $projects]);
    }
    
    public function export($id) 
    {
        return Excel::download(new  ProjectExport($id), 'project.xlsx');
        
    }
}
