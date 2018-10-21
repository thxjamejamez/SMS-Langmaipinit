<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    DB,
    PDF;

class DeliveryController extends Controller
{
    public function index () {
        $cedit = $this->canAccessPage($this->user->id, 47);
        if ($cedit['view'] == 0) return \Redirect::to('/apanel');
        
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
            ->leftjoin('l_city as citycus', 'customer_info.district_id', '=', 'citycus.city_id')
            ->leftjoin('l_province as procus', 'customer_info.province_id', '=', 'procus.province_id')
            ->leftjoin('l_city as citycom', 'customer_info.company_district', '=', 'citycom.city_id')
            ->leftjoin('l_province as procom', 'customer_info.company_province', '=', 'procom.province_id')
            ->where('order_no', $orderid)
            ->select('*'
                    ,'citycus.city_name as city_cus'
                    ,'procus.province_name as pro_cus'
                    ,'citycom.city_name as city_com'
                    ,'procom.province_name as pro_com'
                    )
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

    function Deliveryslip ($orderid) {
        $order = DB::table('order')
            ->join('customer_info', 'order.users_id', '=', 'customer_info.users_id')
            ->leftjoin('l_city as citycus', 'customer_info.district_id', '=', 'citycus.city_id')
            ->leftjoin('l_province as procus', 'customer_info.province_id', '=', 'procus.province_id')
            ->leftjoin('l_city as citycom', 'customer_info.company_district', '=', 'citycom.city_id')
            ->leftjoin('l_province as procom', 'customer_info.company_province', '=', 'procom.province_id')
            ->where('order_no', $orderid)
            ->select('*'
                    ,'citycus.city_name as city_cus'
                    ,'procus.province_name as pro_cus'
                    ,'citycom.city_name as city_com'
                    ,'procom.province_name as pro_com'
                    )
            ->first();

            
        $orderdetail = DB::table('order_detail')
            ->join('l_order_sts_for_work', 'order_detail.pd_sts_id', '=', 'l_order_sts_for_work.id')
            ->join('product', 'product.product_no', '=', 'order_detail.product_no')
            ->join('product_type', 'product.type_no', '=', 'product_type.type_no')
            ->where('order_no', $orderid)
            ->get();
        $pdf = PDF::loadView('delivery.print.deliveryslip',compact('order', 'orderdetail'),[],['format'=>'A4']);
        return $pdf->stream('document.pdf');
    }

}
