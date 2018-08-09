<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});



Route::get('test', function (){
    return view('test');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('apanel', 'adminController@index');
    route::get('/logout', 'Auth\LoginController@logout');
});
Route::resource('user', 'UserController');
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
