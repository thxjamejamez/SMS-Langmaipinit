<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    DB;

class MaterialTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cedit = $this->canAccessPage($this->user->id, 51);
        if ($cedit['view'] == 0) return \Redirect::to('/apanel');
        return view('material.type.index');
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
        DB::table('material_type')
            ->insert(['type_name' => $request['type_name']
                    , 'active' => 1]
                    );
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
        $data = DB::table('material_type')
            ->where('active', 1)
            ->where('type_no', $id)
            ->first();
        return response()->json($data);
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
        DB::table('material_type')
            ->where('type_no', $id)
            ->update(['type_name' => $request['type_name']]);
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
        DB::table('material_type')
            ->where('type_no', $id)
            ->delete();
    }

    function getdata () {
        $data = DB::table('material_type')
            ->where('active', 1)
            ->get();
        return response()->json(['data' => $data]);
    }
}
