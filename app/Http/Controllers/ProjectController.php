<?php

namespace App\Http\Controllers;

use App\Exports\ProjectExport;
use App\Models\project;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class ProjectController extends Controller
{
    //
    public function index(){
        $projects = project::paginate(5);
        //return view('admin.project',['projects' => $projects]);
        return view('admin.project') -> with('projects',$projects);
    }
    public function delete_project(){
        $projects = project::where('id',1)->delete();
        return view('admin.project',['projects' => $projects]);
    }
    public function export($id) 
    {
        return Excel::download(new  ProjectExport($id), 'project.xlsx');
    }
}
