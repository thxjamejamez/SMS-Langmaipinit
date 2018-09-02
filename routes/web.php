<?php

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
    return view('index');
});



Route::get('test', function (){
    return view('test');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('apanel', 'adminController@index');
    route::get('/logout', 'Auth\LoginController@logout');
});
Route::resource('employee', 'EmployeeController');
Route::resource('user', 'UserController');
Route::get('/getuserlist', 'UserController@userlist');

#Product Type
Route::resource('producttype', 'ProducttypeController');
Route::get('/getproducttypelist', 'ProducttypeController@producttypelist');

#Product
Route::resource('product', 'ProductController');
Route::get('/getproductlist', 'ProductController@productlist');
Route::get('/myproduct', 'ProductController@myproduct');
Route::get('/getmyproductlist', 'ProductController@myproductlist');

#Require Quotation
Route::resource('requirequotation', 'RequireQuotationController');
Route::get('/getrequirequotationlist', 'RequireQuotationController@requotationlist');
// Add product for cust when confirm
Route::any('/updatepdcust', 'RequireQuotationController@updatePdCust');

#Quotation
Route::resource('quotation', 'QuotationController');
Route::get('/getquotationlist', 'QuotationController@quotationlist');

#Order
Route::resource('requireorder', 'OrderController');
Route::get('/getrequirorderlist', 'OrderController@myorder');
Route::get('getorderlist', 'OrderController@getorderlist');
Route::get('order', function(){
    return view('order.adminindex');
});
Route::get('/getorderdetail/{orderid}/admin', 'OrderController@getorderdetail');
Route::get('/changests/{order_no}/{sts_id}', 'OrderController@ChangeStatus');
// Route::POST('/storeorder', 'OrderController@Store');


Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
