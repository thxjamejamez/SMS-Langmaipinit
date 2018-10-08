<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\RequireQuotation,
    App\ProductForCust,
    DB;

class RequireQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('quotation.index');            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('quotation.require');        
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
        if($request['requofile']){
            $image = $request->file('requofile');
            $fileName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/file_quotation'), $fileName);
        }
        
        $reQuoEloquent = new RequireQuotation();
        $reQuoEloquent->require_detail = $request['re_detail'];
        if(isset($fileName)){$reQuoEloquent->file = $fileName;}
        $reQuoEloquent->users_id = $user->id;
        $reQuoEloquent->sts_id = 1;
        $reQuoEloquent->save();

        // return back()->with('success', 'Uploaded')->with('path', $fileName);
        return \Redirect::to('requirequotation');
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
        $detail_quotation = DB::table('quotation')
            ->join('product', 'quotation.product_no', '=', 'product.product_no')
            ->join('product_type', 'product.type_no', '=', 'product_type.type_no')
            ->where('require_no', $id)
            ->get();
        return view('quotation.add_pd_cust', compact('detail', 'product', 'id', 'detail_quotation'));
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

    function requotationlist () {
        $user = \Auth::user();
        $data = DB::Table('require_quotation')
            ->join('l_require_sts', 'require_quotation.sts_id', '=', 'l_require_sts.id')
            ->where('users_id', $user->id)
            ->get();
        return response()->json(["data"=>$data]);
    }

    function updatePdCust(){
        try{
            $user = \Auth::user();
            $pd = \Request::all();
            DB::table('quotation')
                ->where('require_no', $pd['require_no'])
                ->where('product_no', $pd['product_no'])
                ->update(['confirm_status'=>2]);
    
            ProductForCust::where('product_no', $pd['product_no'])
                ->where('users_id', $user->id)
                ->delete();
    
            $pdforcustEloquent = new ProductForCust();
            $pdforcustEloquent->product_no = $pd['product_no'];
            $pdforcustEloquent->price = $pd['price'];
            $pdforcustEloquent->update_date = DB::raw('NOW()');
            $pdforcustEloquent->users_id = $user->id;
            $pdforcustEloquent->save();
            
            return 'success';
        } catch (Exception $e){
            return 'fail';
        }

    }
}
