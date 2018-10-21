<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB,
    App\UserPermission,
    App\Navigation;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $user;
    protected $permission;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(\Auth::check()){
                $this->user   = \Auth::user();
                $this->permission = UserPermission::where('user_id',$this->user->id)->first();
            }
            return $next($request);
        });        
    }

    public function canAccessPage($uid=false,$menuid=false){
        if(!isset($uid))$uid = $this->user->id;
        if ($this->user->id == 1) return ['view'=>1];
        $permission_page = $this->permission->page->where('menu_id',$menuid)->first();
        if($permission_page == null) return ['view' => 0];
        return ['view' => $permission_page->view];
    }
}
