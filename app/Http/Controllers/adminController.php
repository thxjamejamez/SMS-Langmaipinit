<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\UserPermission,
    Illuminate\Foundation\Auth\ThrottlesLogins,
    Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;

class adminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        
        // $user = \Auth::user();
        // $permission = UserPermission::with(['user','permission','page'])->where('user_id',$user->id)->first();
        // $items = \App\Navigation::tree_left();
        // $ritems = \App\Navigation::tree_right();
        // var_dump ($items);
        return view('admin');
        // return view('admin', compact('user','permission', 'items', 'ritems'));

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
