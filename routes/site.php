<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
route::get('/',function(){
    return view('front.home');
})->name('home');



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {


    Route::group(['namespace' => 'Site', 'middleware' => 'auth'], function() {

    });


    Route::group(['namespace' => 'Auth', 'middleware' => 'guest'], function() {

       // Route::get('login', 'LoginController@login')->name('login');
      //  Route::post('login', 'LoginController@postLogin')->name('post.login');

    });



});
