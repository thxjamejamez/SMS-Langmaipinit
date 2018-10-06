<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    \App\Permission,
    \App\Navigation,
    \App\PagePermission,
    DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \View::make('permissions.index');
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
        $editpermission = Permission::join('permission_pages','permission_id','=','id')
                        ->where('id',$id)
                        ->select('permission_id','permission_name','menu_id','view')->get();
        $permissions = Navigation::tree();

        return \View::make('permissions.edit', compact('editpermission', 'permissions'));
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
        try {
            $permissionEloquent = Permission::find($id);
            $permissionEloquent->permission_name = trim($request['permission_name']);
            $permissionEloquent->save();
            $oldperpage = DB::table('permission_pages')->select('menu_id')
                ->where('permission_id', $id)
                ->get();
            $old_menuid = array();
            foreach( $oldperpage as $oldpage ){
                array_push($old_menuid,$oldpage->menu_id);
            }
            for($i=0;$i<count($request['menu_id']);$i++){
                if(in_array($request['menu_id'][$i], $old_menuid)){
                    PagePermission::where('permission_id', $id)
                                ->where('menu_id', $request['menu_id'][$i])
                                ->update([ 'view' => $request['view'][$i] ] );
                }else{
                    $permissionMenuEloquent = new PagePermission();
                    $permissionMenuEloquent->permission_id = $permissionEloquent->id;
                    $permissionMenuEloquent->menu_id = $request['menu_id'][$i];
                    $permissionMenuEloquent->view = $request['view'][$i];
                    $permissionMenuEloquent->save();
                }
            }
            \Session::flash('massage','Updated');
            return \Redirect::to('permissions');
        } catch (Exception $e){
            \Session::flash('massage','Not Success !!');
            return \Redirect::to('permissions');
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

    function getlistdata () {
        $data = Permission::where('active', 1)->get();
        return response()->json(['data' => $data]);
    }
}
