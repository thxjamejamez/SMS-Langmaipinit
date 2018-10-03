<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagePermission extends Model
{
    protected $table = 'permission_pages';

    public function page()
    {
        return $this->hasMany('\App\Navigation','id','menu_id');
    }

    public function permission()
    {
        return $this->hasOne('\App\Permission','id','permission_id');
    }
}
