<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    \App\SupplierType,
    \App\Supplier,
    DB;

class ManageMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('material.manage.index');
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
        $user = \Auth::user();
        DB::table('material_purchase')
            ->insert(['material_no' => $request['material_no']
                    ,'unit_purchase' => $request['qty']
                    ,'price_perunit' => $request['unitprice']
                    ,'purchase_date' => DB::raw('NOW()')
                    ,'users_id' => $user->id
                    ,'sup_no' => $request['sup_no']
                    ]);

        $count = DB::table('material')
            ->where('material_no', $request['material_no'])
            ->select('balance')
            ->first();
        
        $sumbalance = $count->balance + $request['qty'];
        DB::table('material')
            ->where('material_no', $request['material_no'])
            ->update(['balance' => $sumbalance
                    ,'sts_ordering' => 0]);
        return 'success';
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

    function getdetailforaddmt ($material_no) {
        $chktype = DB::table('material')->where('material_no', $material_no)->first();
        $chk = SupplierType::where('type_no', $chktype->type_no)->select(DB::raw('GROUP_CONCAT(sup_no) as sup_no'))->first();
        $sup = explode(",",$chk->sup_no);

        $supplier = Supplier::whereIn('sup_no', $sup)->get();
        return response()->json($supplier);
    }

    function adduseMaterial (Request $request) {
        $user = \Auth::user();
        DB::table('material_use')
            ->insert(['material_no' => $request['material_no']
                    ,'use_unit' => $request['use_qty']
                    ,'use_date' => DB::raw('NOW()')
                    ,'users_id' => $user->id
                    ]);

        $count = DB::table('material')
            ->where('material_no', $request['material_no'])
            ->select('balance')
            ->first();

        $balance = $count->balance - $request['use_qty'];
        DB::table('material')
            ->where('material_no', $request['material_no'])
            ->update(['balance' => $balance]);
        return 'success';
    }

    function changestsordetm ($material_no) {
        DB::table('material')
            ->where('material_no', $material_no)
            ->update(['sts_ordering' => 1]);
        return 'success';
    }
}
