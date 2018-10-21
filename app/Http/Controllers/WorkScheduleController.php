<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    DB;

class WorkScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cedit = $this->canAccessPage($this->user->id,46);
        if ($cedit['view'] == 0) return \Redirect::to('/apanel');
        $lworksts = DB::table('l_order_sts_for_work')->select(DB::raw('GROUP_CONCAT(id SEPARATOR \',\') as id'))->first();
        $worksts = $lworksts->id;
        $workstses = DB::table('l_order_sts_for_work')
            ->where('active', 1)
            ->get();
        return view('workschedule.index', compact('worksts', 'workstses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    function getData() {
        $sub1 = '(SELECT COUNT(detail_no) FROM order_detail WHERE order.order_no = order_detail.order_no) as count_pd';
        $sub2 = '(SELECT COUNT(detail_no) FROM order_detail WHERE order.order_no = order_detail.order_no AND order_detail.pd_sts_id = 3) as count_fpd';        
        $order = DB::table('order')
            ->join('l_order_sts_for_work', 'order.status_forwork', '=', 'l_order_sts_for_work.id')
            ->where('order.status_forwork', '>', 0)
            ->select('*'
                    ,DB::raw($sub1)
                    ,DB::raw($sub2)
                    )
            ->get();
        return response()->json(["data"=>$order]);
    }

    function getworkdetail($orderid){
        $order = DB::table('order')
            ->where('order_no', $orderid)
            ->first();

        $orderdetail = DB::table('order_detail')
            ->join('product', 'product.product_no', '=', 'order_detail.product_no')
            ->join('product_type', 'product.type_no', '=', 'product_type.type_no')
            ->where('order_no', $orderid)
            ->get();

        $pdsts = DB::table('l_order_pd_sts')
            ->where('active', 1)
            ->get();

        return response()->json([
                                    'order'=> $order,
                                    'orderdetail'=> $orderdetail,
                                    'pdsts' => $pdsts
                                ]);
    }

    function updateworkpdsts(Request $request){
        DB::table('order_detail')
            ->where('order_no', $request['order_no'])
            ->where('product_no', $request['pd_no'])
            ->update(['pd_sts_id' => $request['sts']]);

        $chk_all = DB::table('order_detail')
            ->where('order_no', $request['order_no'])
            ->select(DB::raw('COUNT(detail_no) as c'))
            ->first();

        $chk = DB::table('order_detail')
            ->where('order_no', $request['order_no'])
            ->select(DB::raw('SUM(if(pd_sts_id = 1, 1, 0)) AS sts1')
                    ,DB::raw('SUM(if(pd_sts_id = 2, 1, 0)) AS sts2')
                    ,DB::raw('SUM(if(pd_sts_id = 3, 1, 0)) AS sts3')
                    )
            ->first();

        if($chk_all->c == $chk->sts1){
            DB::table('order')
            ->where('order_no', $request['order_no'])
            ->update(['status_forwork' => 1
                    ,'status' => 2]);
        }elseif($chk_all->c == $chk->sts3){
            DB::table('order')
            ->where('order_no', $request['order_no'])
            ->update(['status_forwork' => 3
                    ,'status' => 4]);
        }else{
            DB::table('order')
            ->where('order_no', $request['order_no'])
            ->update(['status_forwork' => 2
                    ,'status' => 3]);
        }
        
        return 'success';
    }
}
