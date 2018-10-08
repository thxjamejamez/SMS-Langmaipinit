<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    DB;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('material.index');
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
        DB::table('material')
            ->insert(['material_name' => $request['material_name']
                    ,'active' => 1
                    ,'type_no' => $request['material_type']]);
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
        $detail = DB::table('material')
            ->where('active', 1)
            ->where('material_no', $id)
            ->first();

        $type = DB::table('material_type')
            ->where('active', 1)
            ->get();

        return response()->json(['detail' => $detail
                                ,'type' => $type
                                ]);
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
        DB::table('material')
            ->where('material_no', $id)
            ->update(['material_name' => $request['material_name']
                    ,'type_no' => $request['material_type']]);
        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('material')
            ->where('material_no', $id)
            ->delete();
    }

    public function getdata () {
        $data = DB::table('material')
            ->join('material_type', 'material.type_no', '=', 'material_type.type_no')
            ->where('material.active', 1)
            ->get();

        return response()->json(['data' => $data]);
    }

    function getbuymateriallist () {
        $buymaterial = DB::table('material_purchase')
            ->join('material', 'material_purchase.material_no', '=', 'material.material_no')
            ->join('material_type', 'material.type_no', '=', 'material_type.type_no')
            ->join('supplier', 'material_purchase.sup_no', '=', 'supplier.sup_no')
            ->join('users', 'material_purchase.users_id', '=', 'users.id')
            ->get();
        return response()->json(['data' => $buymaterial]);
    }

    
}
