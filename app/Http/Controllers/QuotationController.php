<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\Quotation,
    DB;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cedit = $this->canAccessPage($this->user->id, 42);
        if ($cedit['view'] == 0) return \Redirect::to('/apanel');
        $lrests = DB::table('l_require_sts')
            ->select(DB::raw('GROUP_CONCAT(id SEPARATOR \',\') as id'))->first();
        $rests = $lrests->id;
        $restses = DB::table('l_require_sts')
            ->where('active', 1)
            ->get();
        return view('admin_quotation.index', compact('rests', 'restses'));
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
        $detail = DB::table('require_quotation')
        ->where('require_no', $id)
        ->first();
    $de_retype = DB::table('re_typeproduct')
        ->join('product_type', 're_typeproduct.type_no', '=', 'product_type.type_no')
        ->where('re_typeproduct.quotation_no', $id)
        ->select(DB::raw('GROUP_CONCAT(type_name) as type_name'))->first();

    $product = DB::table('product')->where('active', 1)->get();
    $detail_quotation = DB::table('quotation')
        ->join('product', 'quotation.product_no', '=', 'product.product_no')
        ->join('product_type', 'product.type_no', '=', 'product_type.type_no')
        ->where('require_no', $id)
        ->get();
    return view('admin_quotation.show', compact('detail', 'product', 'id', 'detail_quotation', 'de_retype'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $retype = DB::table('re_typeproduct')->where('re_typeproduct.quotation_no', $id)->select(DB::raw('GROUP_CONCAT(type_no) as type_no'))->first();
        $bytype = explode(",",$retype->type_no);

        $detail = DB::table('require_quotation')
            ->where('require_no', $id)
            ->first();
        $pdcust = DB::table('product_for_cust')->where('product_for_cust.users_id', $detail->users_id)->select(DB::raw('GROUP_CONCAT(product_no) as product_no'))->first();
        $notpdcust = explode(",",$pdcust->product_no);

        $de_retype = DB::table('re_typeproduct')
            ->join('product_type', 're_typeproduct.type_no', '=', 'product_type.type_no')
            ->where('re_typeproduct.quotation_no', $id)
            ->select(DB::raw('GROUP_CONCAT(type_name) as type_name'))->first();

        $product = DB::table('product')
            ->join('product_type', 'product.type_no', '=', 'product_type.type_no')
            ->when(!in_array(0 , $bytype), function ($product) use($bytype){
                $product->whereIn('product.type_no', $bytype);
            })
            ->when(isset($notpdcust), function ($product) use($notpdcust){
                $product->whereNotIn('product.product_no', $notpdcust);
            })
            ->where('product.active', 1)
            ->where('product_type.active', 1)
            ->get();
        return view('admin_quotation.form', compact('detail', 'product', 'id', 'de_retype'));
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
        try{
            Quotation::where('require_no', $id)->delete();

            foreach($request['product'] as $key => $pd){
                $QuotationEloquent = new Quotation();
                $QuotationEloquent->require_no = $id;
                $QuotationEloquent->product_no = $pd;
                $QuotationEloquent->price = $request['product_price'][$key];
                $QuotationEloquent->confirm_status = 1;
                $QuotationEloquent->save();
            }

            $chk = DB::table('require_quotation')->where('require_quotation.require_no', $id)->first();
            if(isset($chk)){
                if($chk->sts_id == 1){
                    DB::table('require_quotation')
                        ->where('require_quotation.require_no', $id)
                        ->update(['sts_id' => 2]);
                }
            }

            \Session::flash('massage','Inserted');
            return \Redirect::to('quotation');
        } catch (Exception $e){
            \Session::flash('massage','Not Success !!');
            return \Redirect::to('quotation');
        }
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

    function quotationlist () {
        $data = DB::Table('require_quotation')
            ->join('l_require_sts', 'require_quotation.sts_id', '=', 'l_require_sts.id')
            ->get();
        return response()->json(["data"=>$data]);
    }
}
