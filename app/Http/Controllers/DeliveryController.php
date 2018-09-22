<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    DB;

class DeliveryController extends Controller
{
    public function index () {
        $lworksts = DB::table('l_order_sts')
            ->whereIn('id', [4,5])
            ->select(DB::raw('GROUP_CONCAT(id SEPARATOR \',\') as id'))->first();
        $ordersts = $lworksts->id;
        $orderstses = DB::table('l_order_sts')
            ->where('active', 1)
            ->whereIn('id', [4,5])
            ->get();
        return view('delivery.index', compact('ordersts', 'orderstses'));
    }

    function getData() {
        $order = DB::table('order')
            ->join('l_order_sts', 'order.status', '=', 'l_order_sts.id')
            ->whereIn('order.status', [4,5])
            ->select('*')
            ->get();
        return response()->json(["data"=>$order]);
    }

    function getorderdetail($orderid){
        $order = DB::table('order')
            ->join('customer_info', 'order.users_id', '=', 'customer_info.users_id')
            ->where('order_no', $orderid)
            ->first();

        $orderdetail = DB::table('order_detail')
            ->join('l_order_sts_for_work', 'order_detail.pd_sts_id', '=', 'l_order_sts_for_work.id')
            ->join('product', 'product.product_no', '=', 'order_detail.product_no')
            ->join('product_type', 'product.type_no', '=', 'product_type.type_no')
            ->where('order_no', $orderid)
            ->get();


        return response()->json([
                                    'order'=> $order,
                                    'orderdetail'=> $orderdetail
                                ]);
    }
}
