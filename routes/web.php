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
Route::get('/customers', 'CustomerController@index');
/*
|--------------------------------------------------------------------------
| Admin Invoice
|--------------------------------------------------------------------------
*/
Route::get('/invoices','InvoiceController@index');
Route::get('/invoice{invoice_id}','InvoiceController@showInvoiceDetail');
Route::post('/form-add-invoice','InvoiceController@showFormAddInvoice');
Route::post('/add-invoice','InvoiceController@addInvoice');
Route::get('/get-project','ProjectController@show');
Route::get('/get-customer','InvoiceController@showCustomerInfo');
Route::get('/export-invoice{invoice_id}','InvoiceController@exportInvoice');
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






