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

Route::get('/project', 'ProjectController@index');
Route::get('/delete-project', 'ProjectController@delete_project');

Route::get('/item', 'ItemController@index');
Route::get('/item/{projectID}', 'ItemController@findItemByProjectID');

Route::get('/customer', 'CustomerController@index');

Route::get('/estimate', 'EstimateController@index');

Route::get('/invoice', 'InvoiceController@index');

Route::get('/invoice{invoice_id}', 'InvoiceController@show_invoice_detail');

//Route::get('/addinvoice', 'InvoiceController@add_invoice');
Route::post('/show_add_invoice', 'InvoiceController@show_add_invoice');
Route::post('/addInvoice', 'InvoiceController@add_invoice');
Route::get('/get-project', 'ProjectController@get_project');

Route::get('/ajax-request', 'InvoiceController@create');
//Route::post('/ajax-request', 'InvoiceController@store');

//Route::get('/ajax-request-item', 'InvoiceController@getItemByAjax');
Route::get('/get-item{id}', 'InvoiceController@getItem');
//Route::post('/ajax-request', 'InvoiceController@store');

//save file project to excel file
Route::get('/projectexport{id}', 'ProjectController@export');

//test export excel use php
Route::get('/export{invoice_id}={type}', 'InvoiceController@export');




