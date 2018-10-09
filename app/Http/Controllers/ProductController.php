<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\Product,
    DB;

class ProductController extends Controller
{
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
        $producttype = DB::Table('product_type')->where('active', 1)->get();
        $editproduct = Product::where('product_no', $id)->first();
        return view('product.form', compact('editproduct', 'producttype'));
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
            $productEloquent = Product::find($id);
            $productEloquent->type_no = $request['product_type'];
            $productEloquent->product_name = $request['product_name'];
            $productEloquent->product_size = $request['product_size'];
            $productEloquent->product_price = $request['product_price'];
            $productEloquent->active = 1;
            $productEloquent->save();
            \Session::flash('massage','Updated');
            return \Redirect::to('product');
        } catch (Exception $e){
            \Session::flash('massage','Not Success !!');
            return \Redirect::to('product');
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
        Product::destroy($id);
        return 'success';
        
    }

    function productlist() {
        $product = DB::table('product')
            ->join('product_type', 'product.type_no', '=', 'product_type.type_no')
            ->get();
        return response()->json(["data"=>$product]);        
    }

    function myproduct(){
        return view('product.mypdindex');
    }

    function myproductlist(){
        $user = \Auth::user();
        $product = DB::table('product_for_cust')
            ->join('product', 'product_for_cust.product_no', '=', 'product.product_no')
            ->join('product_type', 'product.type_no', '=', 'product_type.type_no')
            ->where('users_id', $user->id)
            ->get();
        return response()->json(["data"=>$product]);
    }
}
