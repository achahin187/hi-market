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

        Route::get('', 'Admin\AdminController@index')->name('home');
        Route::resource('admins', 'Admin\AdminController', ['except' => ['show']]);
        Route::resource('categories', 'Admin\CategoryController');
        Route::resource('vendors', 'Admin\VendorController');
        Route::resource('offers', 'Admin\OfferController');
        Route::resource('requests', 'Admin\RequestController');
        Route::get('products', 'Admin\ProductController@index')->name('products.index');
        Route::get('products/{flag}', 'Admin\ProductController@create')->name('products.create');
        Route::post('products/{flag}', 'Admin\ProductController@store')->name('productsadd');
        Route::get('products/{id}/{flag}/edit', 'Admin\ProductController@edit')->name('products.edit');
        Route::put('products/{id}/{flag}/edit', 'Admin\ProductController@update')->name('products.update');
        Route::delete('products/{id}', 'Admin\ProductController@destroy')->name('products.destroy');

        Route::group(['prefix' => 'orders'],function() {
            Route::get('/', 'Admin\OrderController@index')->name('orders.index');
            Route::get('{order_id}/edit', 'Admin\OrderController@editorder')->name('orders.edit');
            Route::put('{order_id}', 'Admin\OrderController@updateorder')->name('orders.update');
            Route::post('products/add/{order_id}', 'Admin\OrderController@addproduct')->name('products.store');
            Route::get('{order_id}/{product_id}', 'Admin\OrderController@editproduct')->name('orderproduct.edit');
            Route::put('products/{order_id}/{product_id}', 'Admin\OrderController@updateproduct')->name('orderproduct.update');
            Route::delete('products/{order_id}/{product_id}', 'Admin\OrderController@productdelete')->name('orderproduct.delete');
            Route::delete('{order_id}', 'Admin\OrderController@orderdelete')->name('orders.delete');
            Route::put('status/{order_id}', 'Admin\OrderController@status')->name('orders.status');
        });
    });

    Route::get('/home', 'HomeController@index')->name('home');

});


