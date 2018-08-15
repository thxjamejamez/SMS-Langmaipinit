<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    \Yajra\Datatables\Facades\Datatables,
    DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('user.index');
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
        return View('user.profile', compact('title', 'district', 'province', 'group_permission'));
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

    function userlist(){
        // $users = \App\User::join('user_permissions','user_id','=','users.id')
        //             ->join('group_permissions','permission_id','=','group_permissions.id')
        //             ->leftjoin('employee_info', 'users.id', '=', 'employee_info.user_id')
        //             ->select([  'users.id',
        //                         'username', 
        //                         'email', 
        //                         'permission_name',
        //                         'users.active',
        //                         'group_permissions.active as gactive', 
        //                         'employee_info.first_name',
        //                         'employee_info.last_name'
        //                     ])
                            // ->get();
        $users = DB::table('users')
                    ->join('user_permissions','user_permissions.user_id','=','users.id')
                    ->join('group_permissions','user_permissions.permission_id','=','group_permissions.id')
                    ->leftjoin('employee_info', 'users.id', '=', 'employee_info.user_id')
                    ->select([  'users.id',
                                'users.username', 
                                'employee_info.email', 
                                'permission_name', 
                                'employee_info.first_name',
                                'employee_info.last_name'
                    ])
                    ->get();
                    // ->leftjoin('')
                    // ->get();
                    //         dd($users);
                    // ->where('users.id','!=',1);
                    return response()->json(["data"=>$users]);
    }
}
