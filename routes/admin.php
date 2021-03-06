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


    Route::group(['namespace' => 'Dashboard', 'as' => 'admin.', 'middleware' => 'auth:admin', 'prefix' => 'admin'], function () {

        //Dashboard Route and logout
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('logout', 'LoginController@logout')->name('logout');


        //Settings Route
        Route::group(['prefix' => 'settings', 'middleware' => 'can:settings'], function () {
            Route::get('shipping-methods/{type}', 'SettingsController@editShippingMethod')->name('edit.shipping.method');
            Route::put('shipping-methods/{id}', 'SettingsController@updateShippingMethod')->name('update.shipping.method');
        });


        //Profile Routes
        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', 'ProfileController@editProfile')->name('edit.profile');
            Route::put('update', 'ProfileController@updateProfile')->name('update.profile');
        });


        //Categories Routes
        Route::group(['middleware' => 'can:categories'], function () {
            Route::resource('categories', 'CategoriesController')->except('show');
        });

        //Brands Routes
        Route::group(['middleware' => 'can:brands'], function () {
            Route::resource('brands', 'BrandsController')->except('show');
        });

        //Tags Routes
        Route::group(['middleware' => 'can:tags'], function () {
            Route::resource('tags', 'TagsController')->except('show');
        });

        //Create Products Routes
        Route::group(['prefix' => 'products', 'middleware' => 'can:products'], function () {
            Route::get('/', 'ProductsController@index')->name('products');
            Route::get('general-information', 'ProductsController@create')->name('products.general.create');
            Route::post('store-general-information', 'ProductsController@store')->name('products.general.store');

            Route::get('price/{id}', 'ProductsController@getPrice')->name('products.price');
            Route::post('price', 'ProductsController@saveProductPrice')->name('products.price.store');

            Route::get('stock/{id}', 'ProductsController@getStock')->name('products.stock');
            Route::post('stock', 'ProductsController@saveProductStock')->name('products.stock.store');

            Route::get('option/{id}', 'ProductsController@getOption')->name('products.option');
            Route::post('option', 'ProductsController@saveProductOption')->name('products.option.store');

            Route::get('images/{id}', 'ProductsController@addImage')->name('products.images');
            Route::post('images', 'ProductsController@saveProductImage')->name('products.images.store');
            Route::post('images/database', 'ProductsController@saveProductImageDb')->name('products.images.store.db');

        });


        //Edit Products Routes
        Route::group(['prefix' => 'products', 'middleware' => 'can:products'], function () {
            Route::get('edit-general-information/{id}', 'ProductsController@edit')->name('products.general.edit');
            Route::put('update-general-information/{id}', 'ProductsController@update')->name('products.general.update');

            Route::get('edit-price/{id}', 'ProductsController@editPrice')->name('products.price.edit');
            Route::post('update-price', 'ProductsController@updateProductPrice')->name('products.price.update');

            Route::get('edit-stock/{id}', 'ProductsController@editStock')->name('products.stock.edit');
            Route::post('update-stock', 'ProductsController@updateProductStock')->name('products.stock.update');

            Route::get('edit-images/{id}', 'ProductsController@editImage')->name('products.images.edit');
            Route::post('update-images', 'ProductsController@saveProductImage')->name('products.images.update');
            Route::post('update-images/database', 'ProductsController@saveProductImageDb')->name('products.images.update.db');

        });

        //Attribute Routes
        Route::group(['middleware' => 'can:attributes'], function () {
            Route::resource('attributes', 'AttributesController')->except('show');
        });

        //Options Routes
        Route::group(['middleware' => 'can:options'], function () {
            Route::resource('options', 'OptionsController')->except('show');
        });


        //Image Sliders Routes
        Route::group(['prefix' => 'sliders', 'middleware' => 'can:sliders'], function () {
            Route::get('/', 'SliderController@addImage')->name('sliders.create');
            Route::post('images', 'SliderController@saveSliderImage')->name('sliders.images.store');
            Route::post('images/database', 'SliderController@saveSliderImageDb')->name('sliders.images.store.db');
        });


        //Roles Routes
        Route::group(['middleware' => 'can:roles'], function () {
            Route::resource('roles', 'RolesController')->except('show');
        });

        //Admins Routes
        Route::group(['middleware' => 'can:admins'], function () {
            Route::resource('admins', 'AdminsController')->except(['show', 'edit', 'update', 'destroy']);
        });

    });


    //Login Routes
    Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin', 'prefix' => 'admin'], function () {
        Route::get('login', 'LoginController@login')->name('admin.login');
        Route::post('login', 'LoginController@postLogin')->name('admin.post.login');
    });


});




