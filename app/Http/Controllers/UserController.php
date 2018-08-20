<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    \App\CustomerInfo,
    \App\UserPermission,
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
        $chk = $request->validate([
            'nickname' => 'required',
            'username' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ]);
        try{
            // dd($request['permission']);
            $userEloquent = new \App\User();
            $userEloquent->username = trim($request['username']);
            $userEloquent->nickname = $request['nickname'];
            $userEloquent->password = \Hash::make($request['password']);
            $userEloquent->email = trim($request['email']);
            $userEloquent->status = 1;
            $userEloquent->save();

            // if($request['permission']==6){
                $custinfoEloquent = new CustomerInfo();
                $custinfoEloquent->users_id = $userEloquent->id;
                $custinfoEloquent->title_id = $request['title'];
                $custinfoEloquent->first_name = $request['firstname'];
                $custinfoEloquent->last_name = $request['lastname'];
                $custinfoEloquent->address = $request['address'];
                $custinfoEloquent->active = 1;
                $custinfoEloquent->tel = $request['tel'];
                if(isset($request['birthdate'])){$custinfoEloquent->birthdate = date('Y-m-d', strtotime($request['birthdate']));}
                $custinfoEloquent->province_id = $request['province'];
                $custinfoEloquent->district_id = $request['district'];
                if(isset($request['company'])){
                    $custinfoEloquent->company_name = $request['companyname'];
                    $custinfoEloquent->company_credit = $request['creditcompany'];
                    $custinfoEloquent->company_address = $request['address_company'];
                    $custinfoEloquent->company_district = $request['province_company'];
                    $custinfoEloquent->company_province = $request['district_company'];
                }
                $custinfoEloquent->save();
            // }

            $userrolesEloquent = new UserPermission();
            $userrolesEloquent->user_id = $userEloquent->id;
            $userrolesEloquent->permission_id = 6;
            $userrolesEloquent->save();

            \Session::flash('massage','Updated');
            return \Redirect::to('user');
        } catch (Exception $e){
            \Session::flash('massage','Not Success !!');
            return \Redirect::to('user');
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

    function userlist(){
        $emp = DB::table('users')
            ->join('user_permissions','user_permissions.user_id','=','users.id')
            ->join('group_permissions','user_permissions.permission_id','=','group_permissions.id')
            ->join('employee_info', 'users.id', '=', 'employee_info.users_id')
            ->select([  'users.id',
                        'users.username', 
                        'users.email', 
                        'permission_name', 
                        'employee_info.first_name',
                        'employee_info.last_name',
            ]);
        $cust = DB::table('users')
            ->join('user_permissions','user_permissions.user_id','=','users.id')
            ->join('group_permissions','user_permissions.permission_id','=','group_permissions.id')
            ->join('customer_info', 'users.id', '=', 'customer_info.users_id')
            ->select([  'users.id',
                        'users.username', 
                        'users.email', 
                        'permission_name', 
                        'customer_info.first_name',
                        'customer_info.last_name',
            ]);
        $users = $emp->union($cust)->get();
        return response()->json(["data"=>$users]);
    }
}
