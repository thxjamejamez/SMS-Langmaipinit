<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $table = 'user_permissions';
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function permission()
    {
        return $this->hasOne('App\Permission','id','permission_id');
    }

    public function page()
    {
        return $this->hasMany('App\PagePermission','permission_id','permission_id');
    }
}
