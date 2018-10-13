<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB,
    App\UserPermission,
    App\Navigation;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(){
        // $this->user   = \Auth::user();
        // dd(auth);
        // $this->permission = UserPermission::where('user_id',$this->user->id)->first();
    }

    public function canAccessPage($uid=false,$menuid=false){
        if(!isset($uid))$uid = $this->user->id;
        if ($this->user->id == 1) return ['view'=>1];
        $permission_page = $this->permission->page->where('menu_id',$menuid)->first();
        if($permission_page == null) return ['view' => 0];
        return ['view' => $permission_page->view];
    }
}
