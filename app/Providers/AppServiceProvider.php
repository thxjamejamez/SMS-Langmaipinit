<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider,
    \App\Navigation,
    \App\UserPermission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view)
        {
            $user = \Auth::user();
            if(isset($user->id)){
                $user = \Auth::user();
                $permission = UserPermission::with(['user','permission','page'])->where('user_id',$user->id)->first();
                $items = Navigation::tree_left();
                $ritems = Navigation::tree_right();
                $view->with(compact('user','permission','items','ritems'));

            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
