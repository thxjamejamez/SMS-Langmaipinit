<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\Order,
    App\OrderDetail,
    DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
        $product = DB::table('product_for_cust')
            ->join('product', 'product_for_cust.product_no', '=', 'product.product_no')
            ->join('product_type', 'product.type_no', '=', 'product_type.type_no')
            ->where('users_id', $user->id)
            ->get();
        return view('order.create', compact('product'));        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Auth::user();
        $pdorder = json_decode($request['pdorder']);
        if($request->file('file')){
            $image = $request->file('file');
            $fileName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/file_order'), $fileName);
        }
        $orderEloquent = new Order();
        $orderEloquent->users_id = $user->id;
        $orderEloquent->order_date = DB::raw('NOW()');
        $orderEloquent->status = 1;
        $orderEloquent->remark = $request['orderdetail'];
        if(isset($fileName)){$orderEloquent->file = $fileName;}
        $orderEloquent->send_date = $request['senddate'];
        $orderEloquent->save();

        foreach($pdorder as $key => $pd){
            $orderdeEloquent = new OrderDetail();
            $orderdeEloquent->order_no = $orderEloquent->order_no;
            $orderdeEloquent->product_no = $pd->product_no;
            $orderdeEloquent->qty = $pd->qty;
            $orderdeEloquent->price = $pd->price;
            $orderdeEloquent->status = 1;
            $orderdeEloquent->save();
        }

        return response()->json([
                                    'status' => 'success',
                                    'id' => $orderEloquent->order_no
                                ]);
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
        $order = DB::table('order')
            ->where('order_no', $id)
            ->first();

        $orderdetail = DB::table('order_detail')
            ->join('product', 'product.product_no', '=', 'order_detail.product_no')
            ->join('product_type', 'product.type_no', '=', 'product_type.type_no')
            ->where('order_no', $id)
            ->get();
        return view('order.edit', compact('order', 'orderdetail'));
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

    function myorder(){
        $user = \Auth::user();
        $order = DB::table('order')
            ->join('l_order_sts', 'order.status', '=', 'l_order_sts.id')
            ->where('users_id', $user->id)
            ->get();

        return response()->json(["data"=>$order]);
    }

    function getorderlist() {
        $order = DB::table('order')
            ->join('l_order_sts', 'order.status', '=', 'l_order_sts.id')
            ->get();

        return response()->json(["data"=>$order]);
    }

    function getorderdetail($orderid){
        $order = DB::table('order')
            ->where('order_no', $orderid)
            ->first();

        $orderdetail = DB::table('order_detail')
            ->join('product', 'product.product_no', '=', 'order_detail.product_no')
            ->join('product_type', 'product.type_no', '=', 'product_type.type_no')
            ->where('order_no', $orderid)
            ->get();

        return response()->json([
                                    'order'=>$order,
                                    'orderdetail'=>$orderdetail
                                ]);
    }

    function ChangeStatus ($order_no, $sts_id){
        $orderEloquent = Order::find($order_no);
        $orderEloquent->status = $sts_id;
        $orderEloquent->save();

        return 'success';
    }
}
