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
        $cedit = $this->canAccessPage($this->user->id, 43);
        if ($cedit['view'] == 0) return \Redirect::to('/apanel');
        $lworksts = DB::table('l_order_sts')
            ->select(DB::raw('GROUP_CONCAT(id SEPARATOR \',\') as id'))->first();
        $orsts = $lworksts->id;
        $orstses = DB::table('l_order_sts')
            ->where('active', 1)
            ->get();
        return view('order.index', compact('orsts', 'orstses'));
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
        $orderEloquent->send_date = date('Y-m-d', strtotime($request['senddate']));
        $orderEloquent->save();

        foreach($pdorder as $key => $pd){
            $orderdeEloquent = new OrderDetail();
            $orderdeEloquent->order_no = $orderEloquent->order_no;
            $orderdeEloquent->product_no = $pd->product_no;
            $orderdeEloquent->qty = $pd->qty;
            $orderdeEloquent->price = $pd->price;
            $orderdeEloquent->pd_sts_id = 1;
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
            ->join('l_order_sts', 'order.status', '=', 'l_order_sts.id')
            ->leftjoin('l_cancel_reason', 'order.reason_id', '=', 'l_cancel_reason.id')
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
            ->join('l_order_sts', 'order.status', '=', 'l_order_sts.id')
            ->leftjoin('l_cancel_reason', 'order.reason_id', '=', 'l_cancel_reason.id')
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
        if($sts_id == 2){
            $orderEloquent->status_forwork = 1;
        }else{
            $orderEloquent->status_forwork = 0;
        }
        $orderEloquent->save();

        return 'success';
    }

    function reason () {
        $reason = DB::table('l_cancel_reason')->get();
        return response()->json($reason);
    }

    function savereason (Request $request) {
        $orderupdate = Order::find($request['order_no']);
        $orderupdate->status = $request['order_sts'];
        $orderupdate->reason_id = $request['reason_type'];
        if($request['reason_type'] == 2){
            $orderupdate->change_senddate = date('Y-m-d', strtotime($request['changedate']));
        }else if($request['reason_type'] == 3){
            $orderupdate->text_reason = $request['reason'];
        }
        $orderupdate->save();
        return 'success';
    }

    function changestsnotpass($order_no, $sts) {
        if($sts == 1){
            $orderupdate = Order::find($order_no);
            $orderupdate->status = 1;
            $orderupdate->send_date = $orderupdate->change_senddate;
            $orderupdate->save();
            return 'success';
        }else {
            $orderupdate = Order::find($order_no);
            $orderupdate->change_senddate = NULL;
            $orderupdate->save();
            return 'success';

        }
    }

    function adminindex () {
        $cedit = $this->canAccessPage($this->user->id, 45);
        if ($cedit['view'] == 0) return \Redirect::to('/apanel');
        $lworksts = DB::table('l_order_sts')
                ->select(DB::raw('GROUP_CONCAT(id SEPARATOR \',\') as id'))->first();
            $orsts = $lworksts->id;
            $orstses = DB::table('l_order_sts')
                ->where('active', 1)
                ->get();
        return view('order.adminindex', compact('orsts', 'orstses'));
    }
}
