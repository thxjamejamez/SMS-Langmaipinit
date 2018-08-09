<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'group_permissions';
    public function userpermission()
    {
        return $this->hasMany('App\UserPermission','permission_id','id');
    }
    public function pagepermission()
    {
        return $this->hasMany('App\PagePermission','permission_id','id');
    }
}
