<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin',function(){
    return view('admin/home');
});

/*
|--------------------------------------------------------------------------
| Admin Project
|--------------------------------------------------------------------------
*/
Route::get('/projects', 'ProjectController@index');
Route::get('/delete-project', 'ProjectController@destroy');
/*
|--------------------------------------------------------------------------
| Admin Estimate
|--------------------------------------------------------------------------
*/
Route::get('/estimates', 'EstimateController@index');
/*
|--------------------------------------------------------------------------
| Admin Customer
|--------------------------------------------------------------------------
*/
Route::get('/customers', 'CustomerController@index');//get all
Route::get('/customer-edit{id}', 'CustomerController@showFormEditCustomer');//update get
Route::post('/customer-edit', 'CustomerController@editCustomer'); //update post
Route::get('/customer-delete{id}', 'CustomerController@deleteCustomer');//delete
Route::get('/add-customer', 'CustomerController@showFormAddCustomer'); //add get
Route::post('/add-customer', 'CustomerController@addCustomer'); //add post

/*
|--------------------------------------------------------------------------
| Admin Invoice
|--------------------------------------------------------------------------
*/
Route::get('/invoices','InvoiceController@index'); //get all invoice
Route::get('/invoice{invoice_id}','InvoiceController@showInvoiceDetail'); //show invoice detail
Route::post('/form-add-invoice','InvoiceController@showFormAddInvoice'); //show form add invoice
Route::post('/add-invoice','InvoiceController@addInvoice'); //add invoice
Route::get('/get-project','ProjectController@show'); // show all project
Route::get('/get-customer','InvoiceController@showCustomerInfo'); //show customer info
Route::get('/export-invoice{invoice_id}','InvoiceController@exportInvoice'); //export excel
//Route::get('/export-invoice{id}','ProjectController@exportInvoice');
/*
|--------------------------------------------------------------------------
| Admin Item
|--------------------------------------------------------------------------
*/
Route::get('/items', 'ItemController@index');
Route::get('/item/{projectID}', 'ItemController@findItemByProjectID');
/*
|--------------------------------------------------------------------------
| Web Routes Invoice
|--------------------------------------------------------------------------
|
*/






