<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\ProductType,
    DB;

class ProducttypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('producttype.index');    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('producttype.form');            
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
            $productTypeEloquent = new ProductType();
            $productTypeEloquent->type_name = $request['producttype_name'];
            $productTypeEloquent->active = 1;
            $productTypeEloquent->save();
            \Session::flash('massage','Inserted');
            return \Redirect::to('producttype');
        } catch (Exception $e){
            \Session::flash('massage','Not Success !!');
            return \Redirect::to('producttype');
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

    function producttypelist() {
        $data = DB::Table('product_type')
            ->get();
        return response()->json(["data"=>$data]);

    }
}
