<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\UserPermission,
    Illuminate\Foundation\Auth\ThrottlesLogins,
    Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth,
    DB;

class adminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        
        $user = \Auth::user();
        $chk = DB::table('require_quotation')
            ->where('require_quotation.users_id', $user->id)
            ->first();
        $chkpm = DB::table('user_permissions')
            ->where('user_permissions.user_id', $user->id)
            ->first();
        // var_dump ($items);
        return view('index.index', compact('chk','chkpm'));
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
