<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\Product,
    DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('product.index');            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $producttype = DB::Table('product_type')->where('active', 1)->get();
        return View('product.form', compact('producttype'));            
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $productEloquent = new Product();
            $productEloquent->type_no = $request['product_type'];
            $productEloquent->product_name = $request['product_name'];
            $productEloquent->product_size = $request['product_size'];
            $productEloquent->product_price = $request['product_price'];
            $productEloquent->active = 1;
            $productEloquent->save();
            \Session::flash('massage','Inserted');
            return \Redirect::to('product');
        } catch (Exception $e){
            \Session::flash('massage','Not Success !!');
            return \Redirect::to('product');
        }
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

    function productlist() {
        $product = DB::table('product')
            ->join('product_type', 'product.type_no', '=', 'product_type.type_no')
            ->get();
        return response()->json(["data"=>$product]);        
    }
}
