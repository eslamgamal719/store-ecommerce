<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {


    Route::group(['namespace' => 'Dashboard', 'as' => 'admin.' , 'middleware' => 'auth:admin', 'prefix' => 'admin'], function () {

        //Dashboard Route and logout
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('logout', 'LoginController@logout')->name('logout');


        //Settings Route
        Route::group(['prefix' => 'settings'], function () {
            Route::get('shipping-methods/{type}', 'SettingsController@editShippingMethod')->name('edit.shipping.method');
            Route::put('shipping-methods/{id}', 'SettingsController@updateShippingMethod')->name('update.shipping.method');
        });


        //Profile Routes
        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', 'ProfileController@editProfile')->name('edit.profile');
            Route::put('update', 'ProfileController@updateProfile')->name('update.profile');
        });


        //Categories Routes
        Route::resource('categories', 'CategoriesController')->except('show');


        //Brands Routes
        Route::resource('brands', 'BrandsController')->except('show');


        //Tags Routes
        Route::resource('tags', 'TagsController')->except('show');


        //Products Routes
        Route::group(['prefix' => 'products'], function () {
            Route::get('/','ProductsController@index') -> name('products');
            Route::get('general-information','ProductsController@create') -> name('products.general.create');
           Route::post('store-general-information','ProductsController@store') -> name('products.general.store');

            Route::get('price/{id}','ProductsController@getPrice') -> name('products.price');
            Route::post('price','ProductsController@saveProductPrice') -> name('products.price.store');

            Route::get('stock/{id}','ProductsController@getStock') -> name('products.stock');
            Route::post('stock','ProductsController@saveProductStock') -> name('products.stock.store');

            Route::get('images/{id}','ProductsController@addImage') -> name('products.images');
            Route::post('images','ProductsController@saveProductImage') -> name('products.images.store');
            Route::post('images/database','ProductsController@saveProductImageDB') -> name('products.images.store.db');

        });

        //Attribute Routes
        Route::resource('attributes', 'AttributesController')->except('show');

        //Options Routes
        Route::resource('options', 'OptionsController')->except('show');

    });


    //Login Routes
    Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin', 'prefix' => 'admin'], function () {
        Route::get('login', 'LoginController@login')->name('admin.login');
        Route::post('login', 'LoginController@postLogin')->name('admin.post.login');
    });


});




