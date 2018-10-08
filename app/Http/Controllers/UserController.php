<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    \App\CustomerInfo,
    \App\EmployeeInfo,
    \App\UserPermission,
    \App\User,
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
            $userEloquent = new \App\User();
            $userEloquent->username = trim($request['username']);
            $userEloquent->nickname = $request['nickname'];
            $userEloquent->password = \Hash::make($request['password']);
            $userEloquent->email = trim($request['email']);
            $userEloquent->status = 1;
            $userEloquent->save();

            $custinfoEloquent = new CustomerInfo();
            $custinfoEloquent->users_id = $userEloquent->id;
            $custinfoEloquent->title_id = $request['title'];
            $custinfoEloquent->first_name = $request['firstname'];
            $custinfoEloquent->last_name = $request['lastname'];
            $custinfoEloquent->address = $request['address'];
            $custinfoEloquent->active = 1;
            $custinfoEloquent->tel = $request['tel'];
            if($request['birthdate']){$custinfoEloquent->birthdate = date('Y-m-d', strtotime($request['birthdate']));}
            $custinfoEloquent->province_id = $request['province'];
            $custinfoEloquent->district_id = $request['district'];
            $custinfoEloquent->company_credit = $request['creditcompany'];
            if($request['company']){
                $custinfoEloquent->company_name = $request['companyname'];
                $custinfoEloquent->company_address = $request['address_company'];
                $custinfoEloquent->company_district = $request['district_company'];
                $custinfoEloquent->company_province = $request['province_company'];
            }
            $custinfoEloquent->save();

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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \Auth::user();
        $pmedit = DB::table('user_permissions')->where('user_id', $user->id)->first();
        $edituser = User::where('id', $id)->first();
        $editprofile = CustomerInfo::where('users_id', $id)->first();
        $title = DB::Table('l_title')->get();
        $district = DB::table('l_city')->get();
        $province = DB::table('l_province')->get();
        $group_permission = DB::table('group_permissions')->where('active', 1)->get();
        return view('user.profile', compact('edituser', 'editprofile', 'pmedit', 'title', 'district', 'province', 'group_permission'));
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
            $userEloquent = User::find($id);
            $userEloquent->username = trim($request['username']);
            $userEloquent->nickname = $request['nickname'];
            if(isset($request['password'])){ $userEloquent->password = \Hash::make($request['password']); }
            $userEloquent->email = trim($request['email']);
            $userEloquent->status = 1;
            $userEloquent->save();

            $custinfoEloquent = CustomerInfo::where('users_id', $id)->first();
            $custinfoEloquent->title_id = $request['title'];
            $custinfoEloquent->first_name = $request['firstname'];
            $custinfoEloquent->last_name = $request['lastname'];
            $custinfoEloquent->address = $request['address'];
            $custinfoEloquent->active = 1;
            $custinfoEloquent->tel = $request['tel'];
            if($request['birthdate']){$custinfoEloquent->birthdate = date('Y-m-d', strtotime($request['birthdate']));}
            $custinfoEloquent->province_id = $request['province'];
            $custinfoEloquent->district_id = $request['district'];
            $custinfoEloquent->company_credit = $request['creditcompany'];
            if($request['company']){
                $custinfoEloquent->company_name = $request['companyname'];
                $custinfoEloquent->company_address = $request['address_company'];
                $custinfoEloquent->company_district = $request['district_company'];
                $custinfoEloquent->company_province = $request['province_company'];
            }else{
                $custinfoEloquent->company_name =  NULL;
                $custinfoEloquent->company_address = NULL;
                $custinfoEloquent->company_district = NULL;
                $custinfoEloquent->company_province = NULL;
            }
            $custinfoEloquent->save();

            \Session::flash('massage','Updated');
            return \Redirect::back();
        } catch (Exception $e){
            \Session::flash('massage','Not Success !!');
            return \Redirect::back();
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
        try{
            $request = \Request::all();
            UserPermission::where('user_id', $id)->delete();
            User::where('id', $id)->delete();
            if($request['pm'] < 6){
                EmployeeInfo::where('users_id', $id)->delete();
            }else{
                CustomerInfo::where('users_id', $id)->delete();
            }
            return 'success';
        } catch (Exception $e){
            return 'fail';
        }

    }

    function userlist(){
        $emp = DB::table('users')
            ->join('user_permissions','user_permissions.user_id','=','users.id')
            ->join('group_permissions','user_permissions.permission_id','=','group_permissions.id')
            ->join('employee_info', 'users.id', '=', 'employee_info.users_id')
            ->select([  'users.id',
                        'users.username', 
                        'users.email',
                        'permission_id',
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
                        'permission_id',
                        'permission_name', 
                        'customer_info.first_name',
                        'customer_info.last_name',
            ]);
        $users = $emp->union($cust)->get();
        return response()->json(["data"=>$users]);
    }

    function profiledetail() {
        $user = \Auth::user();
        $pmedit = DB::table('user_permissions')->where('user_id', $user->id)->first();
        if($pmedit->permission_id == 6){
            $edituser = User::where('id', $user->id)->first();
            $editprofile = CustomerInfo::where('users_id', $user->id)->first();
            $title = DB::Table('l_title')->get();
            $district = DB::table('l_city')->get();
            $province = DB::table('l_province')->get();
            $group_permission = DB::table('group_permissions')->where('active', 1)->get();
            return view('user.profile', compact('edituser', 'editprofile', 'pmedit', 'title', 'district', 'province', 'group_permission'));    
        }else{
            $edituser = User::where('id', $user->id)->first();
            $editprofile = EmployeeInfo::where('users_id', $user->id)->first();
            $editUserPermission = UserPermission::where('user_id', $user->id)->first();
            $title = DB::Table('l_title')->get();
            $district = DB::table('l_city')->get();
            $province = DB::table('l_province')->get();
            $group_permission = DB::table('group_permissions')->where('active', 1)->get();
            return view('employee.profile', compact('edituser', 'pmedit', 'editprofile', 'editUserPermission', 'title', 'district', 'province', 'group_permission'));    
        }

    }
}
