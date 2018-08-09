<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
	protected $table = 'navigation_menu';
    protected $primaryKey = 'menu_id';
	public function parent() {

        return $this->hasOne('\App\Navigation', 'menu_id', 'parent_id');

    }

    public function children() {

        return $this->hasMany('\App\Navigation', 'parent_id', 'menu_id')->where('active','=',1)->orderby('priority');

    }

    public static function tree() {

        return static::with(['parent','children'])
                ->where('parent_id', '=', 0)
                ->where('active','=',1)
                ->orderby('menu_index')
                ->orderby('priority')
                ->get();

    }

    public static function tree_left() {

        return static::with(['parent','children'])
                ->where([['parent_id', '=', 0],['menu_index','=',1],['active','=',1]])
                ->orderby('priority')
                ->get();

    }

    public static function tree_right() {

        return static::with(['parent','children'])
                ->where([['parent_id', '=', 0],['menu_index','=',2],['active','=',1]])
                ->orderby('priority')
                ->get();

    }

    public function pagepermission()
    {
        return $this->hasMany('App\PagePermission','permission_id','menu_id');
    }

}
