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
        return view('admin_quotation.index');
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
        $detail = DB::table('require_quotation')
            ->where('require_no', $id)
            ->first();
        $product = DB::table('product')->where('active', 1)->get();
        return view('admin_quotation.form', compact('detail', 'product', 'id'));
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
