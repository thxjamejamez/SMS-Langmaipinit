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
        $cedit = $this->canAccessPage($this->user->id, 2);
        if ($cedit['view'] == 0) return \Redirect::to('/apanel');
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
            if($request['pdtypefile']){
                $image = $request->file('pdtypefile');
                $fileName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('/file_producttype'), $fileName);
            }

            $productTypeEloquent = new ProductType();
            $productTypeEloquent->type_name = $request['producttype_name'];
            if(isset($fileName)){$productTypeEloquent->type_file = $fileName;}
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
        $pdtype = DB::Table('product_type')
            ->where('product_type.type_no', $id)
            ->first();

        return view('producttype.form', compact('pdtype'));
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
            if($request['pdtypefile']){
                $image = $request->file('pdtypefile');
                $fileName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('/file_producttype'), $fileName);
            }

            $pdtype = ProductType::find($id);
            $pdtype->type_name = $request['producttype_name'];
            if(isset($fileName)){$pdtype->type_file = $fileName;}
            $pdtype->save();

            \Session::flash('massage','Updated');
            return \Redirect::to('producttype');
        } catch (Exception $e){
            \Session::flash('massage','Not Success !!');
            return \Redirect::to('producttype');
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
        $pdtype = ProductType::find($id);
        if(isset($pdtype->file_type)){
            unlink('file_producttype/'.$pdtype->type_file);
        }
        ProductType::destroy($id);
        return 'success';

    }

    function producttypelist() {
        $data = DB::Table('product_type')
            ->get();
        return response()->json(["data"=>$data]);

    }

    function delpictype($type_no) {
        $pdtype = ProductType::find($type_no);
        unlink('file_producttype/'.$pdtype->type_file);
        $pdtype->type_file = '';
        $pdtype->save();
            
        return 'success';

    }
}
