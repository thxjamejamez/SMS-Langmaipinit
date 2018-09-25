<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    \App\Supplier,
    \App\SupplierType,
    DB;

class MaterialSellerController extends Controller
{
    public function index()
    {
        return view('material.seller.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = DB::table('material_type')
            ->where('active', 1)
            ->get();
        return view('material.seller.form', compact('type'));        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplierEloquent = new Supplier();
        $supplierEloquent->sup_name = $request['sup_name'];
        $supplierEloquent->address = $request['address'];
        $supplierEloquent->email = $request['email'];
        $supplierEloquent->tel = $request['tel'];
        $supplierEloquent->save();

        if(isset($request['mt_type'])){
            foreach($request['mt_type'] as $type){
                $suppliertypeEloquent = new SupplierType();
                $suppliertypeEloquent->sup_no = $supplierEloquent->sup_no;
                $suppliertypeEloquent->type_no = $type;
                $suppliertypeEloquent->save();
            }
        }
        return redirect('materialseller');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $editsupplier = Supplier::where('sup_no', $id)->first();
        $editsuppliertype = SupplierType::where('sup_no', $id)->select(DB::raw('GROUP_CONCAT(type_no) as type_no'))->first();
        $type = DB::table('material_type')
            ->where('active', 1)
            ->get();
        return view('material.seller.form', compact('editsupplier', 'editsuppliertype', 'type'));      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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
        $supplierUpdate = Supplier::find($id);
        $supplierUpdate->sup_name = $request['sup_name'];
        $supplierUpdate->address = $request['address'];
        $supplierUpdate->email = $request['email'];
        $supplierUpdate->tel = $request['tel'];
        $supplierUpdate->save();

        $supplierTypeUpdate = SupplierType::where('sup_no', $id);
        $supplierTypeUpdate->delete();

        if(isset($request['mt_type'])){
            foreach($request['mt_type'] as $type){
                $supplierTypeUpdate = new SupplierType();
                $supplierTypeUpdate->sup_no = $supplierUpdate->sup_no;
                $supplierTypeUpdate->type_no = $type;
                $supplierTypeUpdate->save();
            }
        }

        return redirect('materialseller');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplierdel = Supplier::find($id);
        $supplierdel->delete();

        $supplierTypedel = SupplierType::where('sup_no', $id);
        $supplierTypedel->delete();
        return 'success';
    }

    function getdata () {
        $data = Supplier::get();
        return response()->json(['data' => $data]);
    }
}
