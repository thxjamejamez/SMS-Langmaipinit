<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    \App\Http\Models\EmployeeInfo,
    DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = DB::Table('l_title')->get();
        $district = DB::table('l_city')->get();
        $province = DB::table('l_province')->get();
        $group_permission = DB::table('group_permissions')->where('active', 1)->get();
        return View('employee.profile', compact('title', 'district', 'province', 'group_permission'));
    }

    public function store(Request $request)
    {
        $userEloquent = new \App\User();
        $userEloquent->username = trim($request['username']);
        $userEloquent->name = '';
        $userEloquent->password = \Hash::make($request['password']);
        $userEloquent->email = trim($request['email']);
        $userEloquent->status = 1;
        $userEloquent->save();

        if($request['permission']!=6){
            
        }
        
    }

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
}
