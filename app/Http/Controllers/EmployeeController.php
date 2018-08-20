<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request,
    \App\EmployeeInfo,
    \App\UserPermission,
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
    
            if($request['permission']!=6){
                $empinfoEloquent = new EmployeeInfo();
                $empinfoEloquent->users_id = $userEloquent->id;
                $empinfoEloquent->title_id = $request['title'];
                $empinfoEloquent->first_name = $request['firstname'];
                $empinfoEloquent->last_name = $request['lastname'];
                $empinfoEloquent->address = $request['address'];
                $empinfoEloquent->email = $request['email'];
                $empinfoEloquent->tel = $request['tel'];
                $empinfoEloquent->salary = $request['salary'];
                $empinfoEloquent->active = 1;
                if(isset($request['birthdate'])){$empinfoEloquent->birthdate = date('Y-m-d', strtotime($request['birthdate']));}
                if(isset($request['startdate'])){$empinfoEloquent->start_date = date('Y-m-d', strtotime($request['startdate']));}
                if(isset($request['enddate'])){$empinfoEloquent->end_date = date('Y-m-d', strtotime($request['enddate']));}
                $empinfoEloquent->province_id = $request['province'];
                $empinfoEloquent->district_id = $request['district'];
                $empinfoEloquent->save();
            }
    
            $userrolesEloquent = new UserPermission();
            $userrolesEloquent->user_id = $userEloquent->id;
            $userrolesEloquent->permissions_id = $request['permission'];
            $userrolesEloquent->save();
            
            \Session::flash('massage','Updated');
            return \Redirect::to('user');
        } catch (Exception $e){
            \Session::flash('massage','Not Success !!');
            return \Redirect::to('user');
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