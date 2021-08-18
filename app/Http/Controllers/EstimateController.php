<?php

namespace App\Http\Controllers;
use App\Models\Estimate;
use Illuminate\Http\File;
use Illuminate\Http\Request;

class EstimateController extends Controller
{
    public function index(){
        $estimates = Estimate::paginate(5);
        //return view('admin.project',['projects' => $projects]);
        return view('admin.estimate') -> with('estimates',$estimates);
    }
    public function downloadFile(){
        $filePath = public_path("Ve may bay.PDF");
    	$headers = ['Content-Type: application/pdf'];
    	$fileName = time().'.pdf';
    	return response()->download($filePath, $fileName, $headers);
    }
    public function uploadFile(){
        return view('admin.upload-estimate');
    }
    public function uploadStore(Request $request){
 
           $name = $request->file('file')->getClientOriginalName();
           $path = $request->file('file')->store('public/files');
           $save = new File($path);
           $save->name = $name;
           $save->path = $path;
           return redirect('/file-upload')->with('status', 'File Has been uploaded successfully in laravel 8');


    }
}
