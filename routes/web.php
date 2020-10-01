<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


// User Routes



// Admin Routes

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {


    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/logout',function(){

        if(\Auth::check())
        {
            \Auth::logout();
            return redirect('/home');
        }
        else
        {
            return redirect('/');
        }
    })->name('logout');

    Auth::routes();

    Route::group(['prefix' => 'admin','middleware' => 'auth'],function() {

        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('', 'HomeController@index')->name('home');
        Route::resource('admins', 'Admin\AdminController', ['except' => ['show']]);
        Route::resource('categories', 'Admin\CategoryController',['except' => ['show']]);
        Route::resource('vendors', 'Admin\VendorController',['except' => ['show']]);
        Route::resource('offers', 'Admin\OfferController',['except' => ['show']]);
        Route::resource('requests', 'Admin\RequestController');
        Route::resource('reasons', 'Admin\ReasonController');
        Route::resource('settings', 'Admin\SettingsController',['except' => ['show','create']]);
        Route::resource('points', 'Admin\PointController',['except' => ['show']]);
        Route::resource('supermarkets', 'Admin\SupermarketController',['except' => ['show']]);
        Route::resource('subcategories', 'Admin\SubcategoryController',['except' => ['show']]);
        Route::resource('roles', 'Admin\RoleController');
        Route::resource('teams', 'Admin\TeamController');
        Route::resource('clients', 'Admin\ClientController');
        Route::resource('permissions', 'Admin\PermissionController');

        Route::put('status/{supermarket_id}', 'Admin\SupermarketController@status')->name('supermarket.status');
        Route::put('points/status/{point_id}', 'Admin\PointController@status')->name('points.status');
        Route::put('reasons/status/{reason_id}', 'Admin\ReasonController@status')->name('reason.status');
        Route::put('offers/status/{reason_id}', 'Admin\OfferController@status')->name('offers.status');

        Route::group(['prefix' => 'products'],function() {

            Route::get('upload', 'Admin\ProductController@upload')->name('products.upload');
            Route::get('{id}/{flag}/clone', 'Admin\ProductController@clone')->name('products.clone');
            Route::get('{flag?}', 'Admin\ProductController@index')->name('products.index');
            Route::get('show/{flag}', 'Admin\ProductController@show')->name('products.show');
            Route::get('create/{flag}', 'Admin\ProductController@create')->name('products.create');
            Route::post('{flag}', 'Admin\ProductController@store')->name('productsadd');
            Route::get('{id}/{flag}/edit', 'Admin\ProductController@edit')->name('products.edit');
            Route::put('{id}/{flag}/edit', 'Admin\ProductController@update')->name('products.update');
            Route::put('status/{product_id}/{flag}', 'Admin\ProductController@status')->name('product.status');
            Route::delete('{id}', 'Admin\ProductController@destroy')->name('products.destroy');

        });

        Route::group(['prefix' => 'export'],function() {

            Route::get('admins', 'Admin\AdminController@export')->name('admins.export');
            Route::get('products', 'Admin\ProductController@export')->name('products.export');
        });

        Route::group(['prefix' => 'import'],function() {

            Route::post('admins', 'Admin\AdminController@import')->name('admins.import');
            Route::post('products', 'Admin\ProductController@import')->name('products.import');
        });


        Route::group(['prefix' => 'orders'],function() {

            Route::get('{cancel?}', 'Admin\OrderController@index')->name('orders.index');
            Route::get('add/{request_id}', 'Admin\OrderController@create')->name('orders.create');
            Route::post('add/{request_id}', 'Admin\OrderController@store')->name('orders.store');
            Route::get('{order_id}/edit', 'Admin\OrderController@editorder')->name('orders.edit');
            Route::put('{order_id}', 'Admin\OrderController@updateorder')->name('orders.update');
            Route::post('products/add/{order_id}', 'Admin\OrderController@addproduct')->name('products.store');
            Route::get('{order_id}/{product_id}', 'Admin\OrderController@editproduct')->name('orderproduct.edit');
            Route::put('products/{order_id}/{product_id}', 'Admin\OrderController@updateproduct')->name('orderproduct.update');
            Route::delete('products/{order_id}/{product_id}', 'Admin\OrderController@productdelete')->name('orderproduct.delete');
            Route::delete('{order_id}', 'Admin\OrderController@orderdelete')->name('orders.delete');
            Route::put('status/{order_id}', 'Admin\OrderController@status')->name('orders.status');
            Route::post('cancel', 'Admin\OrderController@cancel')->name('orders.cancel');
        });


        Route::get('supermarkets/offers/{supermarket_id}', 'Admin\OfferController@supermarketoffers')->name('supermarket.offers');
        Route::get('supermarkets/products/{supermarket_id}/{flag}', 'Admin\ProductController@supermarketproducts')->name('supermarket.products');



    });

});


