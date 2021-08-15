<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        $customers = Customer::paginate(5);
        //return view('admin.project',['projects' => $projects]);
        return view('admin.customer') -> with('customers',$customers);
    }
    public function create(){} // show create form
    public function store(Request $request){ } // handle the form POST 
    public function show($id){} // show a single domain
    public function edit($id){} // show edit page
    public function update(Request $request, $id){} // handle show edit page POST
    public function destroy($id){} // delete a domain
                                
                             
         // c1 $query = DB::table('user_users')->delete();
        // // check data deleted or not
        // if ($query > 0) {
        //     return response()->json('202 Accepted', 202);
        // } else {
        //     return response()->json('404 Not Found', 404);
        // }
        // c2 $success = DB::table('user_users')->count() === 0;
        // $queryStatus;
        // try {
        //     DB::table('user_')->where('column',$something)->delete();
        //     $queryStatus = "Successful";
        // } catch(Exception $e) {
        //     $queryStatus = "Not success";
        // }
        // return view('datenbank')->with('message', $queryStatus);
        // $query = DB::table('user_users')->delete(); 

        // if ($query) {
        //     //query successful
        // }  
}
