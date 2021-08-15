<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Get list customer
     */
    public function index(){
        $customers = Customer::paginate(10);
        return view('admin.Customer.customer')->with('customers',$customers);
    }
    /**
     * Show form input info customer to add
     */
    public function showFormAddCustomer(){
        return view('admin.Customer.add_customer');
    } 
    /**
     * function insert customer
     */
    public function addCustomer(Request $request){
        DB::beginTransaction();
        try {
           $customer = array(
               'name' => $request->customer_name,
               'adress' => $request->address,
               'phone' => $request->phone_number,
               'fax' => $request->fax_number
       );
           Customer::insert($customer);
           DB::commit();
       }
       catch (Exception $e) {
               DB::rollback();
       }
       return redirect('customers')->with('success', 'Thêm khách hàng thành công!'); 
    }
    /**
     * 
     */
    //show edit customer
    public function showFormEditCustomer($id){
        $customers = Customer::showCustomerById($id);
        return view('admin.Customer.edit_customer')->with('customers',$customers);; 
    } 
    /**
     * Update info customer
     */
    public function editCustomer(Request $request){
        DB::beginTransaction();
        try {
           $customer = array(
               'name' => $request->customer_name,
               'adress' => $request->address,
               'phone' => $request->phone_number,
               'fax' => $request->fax_number
       );
           Customer::edit($request->customer_id,$customer);
           DB::commit();
       }
       catch (Exception $e) {
               DB::rollback();
       }
       return redirect('customers')->with('success', 'Cập nhật khách hàng thành công!'); 
    } 
    /**
     * Delete customer
     */
    public function deleteCustomer($id){
        DB::beginTransaction();
        try {
           Customer::destroy($id);
           DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            }
       return redirect('customers')->with('success', 'Xoá khách hàng thành công!'); 
    } 
    
                                 
}
