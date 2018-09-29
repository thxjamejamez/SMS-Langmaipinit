<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    DB;

class CreInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoice.create.index');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('invoice.create.createIV');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function userhaveInvoice () {
        $orderdetail =  DB::table('invoice_detail')->pluck('invoice_detail.order_no');
        $userforIV = DB::table('order')
        ->join('customer_info', 'order.users_id', '=', 'customer_info.users_id')
        ->when(!isset($orderdetail), function ($userIv) use ($orderdetail){
                $userIv->whereNotIn('order.order_no', $orderdetail);
        })
        ->where('order.status', 5)
        ->select('customer_info.users_id'
                ,'customer_info.first_name'
                ,'customer_info.last_name'
                ,'customer_info.company_name'
                )
        ->groupBy('order.users_id')
        ->get();
        return [ 'data' => $userforIV ];
    }

    function createIV($user) {
        $orderdetail =  DB::table('invoice_detail')->pluck('invoice_detail.order_no');
        $order = DB::table('order')
            ->join('l_order_sts', 'order.status', '=', 'l_order_sts.id')
            ->where('order.users_id', $user)
            ->where('order.status', 5)
            ->when(!isset($orderdetail), function ($userIv) use ($orderdetail){
                $userIv->whereNotIn('order.order_no', $orderdetail);
            })
            ->get();

        return view('invoice.create.createIV', compact('order'));

    }
}
