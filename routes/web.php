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
    $cemp = DB::table('employee_info')->select(DB::raw('COUNT(emp_no) AS emp'))->first();
    $ccust = DB::table('customer_info')->select(DB::raw('COUNT(cust_no) AS cust'))->first();
    $cpro = DB::table('product')->select(DB::raw('COUNT(product_no) AS pro'))->first();
    $csell = DB::table('order')->select(DB::raw('COUNT(order_no) AS ord'))->first();
    return view('index', compact('cemp', 'ccust', 'cpro', 'csell'));
});



Route::get('test', function (){
    return view('test');
});

Auth::routes();
Route::middleware(['web','auth'])->group(function () {
    Route::get('apanel', 'adminController@index');
    route::get('/logout', 'Auth\LoginController@logout');
    #User
    Route::resource('user', 'UserController');
    Route::resource('employee', 'EmployeeController');
    Route::get('/getuserlist', 'UserController@userlist');
    Route::get('/profile', 'UserController@profiledetail');
    Route::get('/empinfo', 'EmployeeController@empinfo');
    Route::get('/custinfo', 'UserController@custinfo');
    Route::get('/getemplist', 'EmployeeController@emplist');
    Route::get('/getcustlist', 'UserController@custlist');


    #Product Type
    Route::resource('producttype', 'ProducttypeController');
    Route::get('/getproducttypelist', 'ProducttypeController@producttypelist');
    Route::get('/delpictype/{id}', 'ProducttypeController@delpictype');

    #Product
    Route::resource('product', 'ProductController');
    Route::get('/getproductlist', 'ProductController@productlist');
    Route::get('/myproduct', 'ProductController@myproduct');
    Route::get('/getmyproductlist', 'ProductController@myproductlist');

    #Require Quotation
    Route::resource('requirequotation', 'RequireQuotationController');
    Route::get('/getrequirequotationlist', 'RequireQuotationController@requotationlist');
    Route::get('/pdfindprice/{id}', 'RequireQuotationController@pdfindprice');
    // Add product for cust when confirm
    Route::any('/updatepdcust', 'RequireQuotationController@updatePdCust');

    #Quotation
    Route::resource('quotation', 'QuotationController');
    Route::get('/getquotationlist', 'QuotationController@quotationlist');

    #Order
    Route::resource('requireorder', 'OrderController');
    Route::get('/getrequirorderlist', 'OrderController@myorder');
    Route::get('getorderlist', 'OrderController@getorderlist');
    Route::get('order', 'OrderController@adminindex');
    Route::get('/getorderdetail/{orderid}/admin', 'OrderController@getorderdetail');
    Route::get('/changests/{order_no}/{sts_id}', 'OrderController@ChangeStatus');
    Route::get('/reason', 'OrderController@reason');
    Route::POST('/savereason', 'OrderController@savereason');
    Route::get('/changestsnotpass/{order_no}/{sts}', 'OrderController@changestsnotpass');
    // Route::POST('/storeorder', 'OrderController@Store');


    #work schedule
    Route::resource('workschedule', 'WorkScheduleController');
    Route::get('getorderforwork', 'WorkScheduleController@getData');
    Route::get('/getworkdetail/{orderid}', 'WorkScheduleController@getworkdetail');
    Route::any('/updateworksts', 'WorkScheduleController@updateworkpdsts');

    #delivery
    Route::get('delivery', 'DeliveryController@index');
    Route::get('getdoneorder', 'DeliveryController@getData');
    Route::get('/getorderdetailsend/{orderid}', 'DeliveryController@getorderdetail');
    Route::get('deliveryslip/{orderid}/pdf', 'DeliveryController@Deliveryslip');

    #Material 
    Route::resource('material', 'MaterialController');
    Route::get('getmaterial', 'MaterialController@getdata');
    Route::get('buymaterial', 'MaterialController@buymaterial');
    Route::get('/getbuymateriallist', 'MaterialController@getbuymateriallist');
    #Supplier
    Route::resource('materialseller', 'MaterialSellerController');
    Route::get('getsupplier', 'MaterialSellerController@getdata');

    #type
    Route::resource('materialtype', 'MaterialTypeController');
    Route::get('getmaterialtype', 'MaterialTypeController@getdata');

    #manage
    Route::resource('managematerial', 'ManageMaterialController');
    Route::get('getdetailforaddmt/{id}', 'ManageMaterialController@getdetailforaddmt');
    Route::post('managematerialuse', 'ManageMaterialController@adduseMaterial');
    Route::get('changestsordetm/{id}', 'ManageMaterialController@changestsordetm');
    

    #Permissions
    Route::resource('permissions','PermissionController');
    Route::get('getpermissionslist', 'PermissionController@getlistdata');

    #invoice
    Route::resource('createinvoice', 'CreInvoiceController');
    Route::get('getuserforcreInvoice', 'CreInvoiceController@userhaveInvoice');
    Route::get('createIV/{id}', 'CreInvoiceController@createIV');
    Route::get('getlistForIv/{id}', 'CreInvoiceController@getlistForIv');
    Route::post('saveIv', 'CreInvoiceController@saveIV');
    Route::get('admininvoice', 'CreInvoiceController@admininvoice');
    Route::get('invoicedetail/{id}', 'CreInvoiceController@invoicedetail');
    Route::get('/detail/print/{id}', 'CreInvoiceController@printinvoicedetail');
    #my Invoice
    Route::get('/myinvoice', 'CreInvoiceController@myinvoiceindex');
    Route::get('/getmyinvoice', 'CreInvoiceController@getmyinvoice');
    Route::post('/updateslip', 'CreInvoiceController@updateslip');
    Route::get('/getdetailpay/{id}', 'CreInvoiceController@getdetailpay');
    Route::get('/updatepay/{id}/{sts}', 'CreInvoiceController@updatepay');

    #report
    Route::get('salesummary', 'SaleSummaryController@index');
    Route::get('salesummaryget', 'SaleSummaryController@getdata');
    Route::get('salary', 'EmployeeController@empsalary');
    Route::get('getsalary', 'SaleSummaryController@getsalary');



    Route::get('/home', 'HomeController@index')->name('home');

});
