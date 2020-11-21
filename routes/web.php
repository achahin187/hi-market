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
        Route::resource('notifications', 'Admin\NotificationController');
        Route::resource('measures', 'Admin\UnitController');
        Route::resource('sizes', 'Admin\SizeController');
        Route::resource('cities', 'Admin\CityController');
        Route::resource('areas', 'Admin\AreaController');
        Route::resource('countries', 'Admin\CountryController');
        Route::resource('delivery', 'Admin\DeliveryController');


        Route::get('profile', ['as' => 'profile.edit', 'uses' => 'Admin\ProfileController@edit']);
        Route::put('profile', ['as' => 'profile.update', 'uses' => 'Admin\ProfileController@update']);
        Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'Admin\ProfileController@password']);

        Route::put('status/{supermarket_id}', 'Admin\SupermarketController@status')->name('supermarket.status');
        //export supermarket    
        Route::get('supermarket/export/', 'Admin\SupermarketController@export')->name('supermarket.export');

        Route::put('branches/status/{branch_id}', 'Admin\BranchController@status')->name('branch.status');
        Route::put('points/status/{point_id}', 'Admin\PointController@status')->name('points.status');
        Route::put('reasons/status/{reason_id}', 'Admin\ReasonController@status')->name('reason.status');
        Route::put('offers/status/{offer_id}', 'Admin\OfferController@status')->name('offers.status');
        Route::put('clients/status/{client_id}', 'Admin\ClientController@status')->name('clients.status');
        Route::put('areas/status/{area_id}', 'Admin\AreaController@status')->name('areas.status');
        Route::put('countries/status/{country_id}', 'Admin\CountryController@status')->name('countries.status');
        Route::put('cities/status/{city_id}', 'Admin\CityController@status')->name('cities.status');

        Route::group(['prefix' => 'products'],function() {

            Route::get('{id}/{flag}/clone/{supermarket_id?}/{branch_id?}', 'Admin\ProductController@clone')->name('products.clone');
            Route::get('{flag?}', 'Admin\ProductController@index')->name('products.index');
            Route::get('show/{flag}/{supermarket_id?}/{branch_id?}', 'Admin\ProductController@show')->name('products.show');
            Route::get('create/{flag}/{supermarket_id?}/{branch_id?}', 'Admin\ProductController@create')->name('products.create');
            Route::post('{flag}/{supermarket_id?}/{branch_id?}', 'Admin\ProductController@store')->name('productsadd');
            Route::get('{id}/{flag}/edit/{supermarket_id?}/{branch_id?}', 'Admin\ProductController@edit')->name('products.edit');
            Route::put('{id}/{flag}/edit/{supermarket_id?}/{branch_id?}', 'Admin\ProductController@update')->name('products.update');
            Route::put('status/{product_id}/{flag}', 'Admin\ProductController@status')->name('product.status');
            Route::delete('{id}/{supermarket_id?}/{branch_id?}', 'Admin\ProductController@destroy')->name('products.destroy');

        });

        Route::group(['prefix' => 'branches'],function() {

            Route::get('', 'Admin\BranchController@index')->name('branches.index');
            Route::get('create/{supermarket_id?}', 'Admin\BranchController@create')->name('branches.create');
            Route::post('{supermarket_id?}', 'Admin\BranchController@store')->name('branches.store');
            Route::get('{id}/edit/{supermarket_id?}', 'Admin\BranchController@edit')->name('branches.edit');
            Route::put('{id}/edit/{supermarket_id?}', 'Admin\BranchController@update')->name('branches.update');
            Route::put('status/{branch_id}', 'Admin\BranchController@status')->name('branch.status');
            Route::delete('{id}/{supermarket_id?}', 'Admin\BranchController@destroy')->name('branches.destroy');

        });


        Route::group(['prefix' => 'offers'],function() {

            Route::get('offers', 'Admin\OfferController@index')->name('offers.index');
            Route::get('create/{supermarket_id?}/{branch_id?}', 'Admin\OfferController@create')->name('offers.create');
            Route::post('{supermarket_id?}/{branch_id?}', 'Admin\OfferController@store')->name('offers.store');
            Route::get('{id}/edit/{supermarket_id?}/{branch_id?}', 'Admin\OfferController@edit')->name('offers.edit');
            Route::put('{id}/edit/{supermarket_id?}/{branch_id?}', 'Admin\OfferController@update')->name('offers.update');
            Route::put('status/{offer_id}', 'Admin\OfferController@status')->name('offers.status');
            Route::delete('{id}/{supermarket_id?}/{branch_id?}', 'Admin\OfferController@destroy')->name('offers.destroy');

        });

        Route::group(['prefix' => 'export'],function() {

            Route::get('admins', 'Admin\AdminController@export')->name('admins.export');
            Route::get('products', 'Admin\ProductController@export')->name('products.export');
            Route::get('products/download', 'Admin\ProductController@download')->name('products.downloadsample');
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

            Route::get('{order_id}/assign', 'Admin\OrderController@assignorder')->name('orders.assign');
            
            Route::put('{order_id}', 'Admin\OrderController@updateorder')->name('orders.update');
            Route::put('order_client/{order_id}', 'Admin\OrderController@updateclient')->name('order_client.update');
            Route::post('products/add/{order_id}', 'Admin\OrderController@addproduct')->name('products.store');
            Route::get('{order_id}/{product_id}', 'Admin\OrderController@editproduct')->name('orderproduct.edit');
            Route::put('products/{order_id}/{product_id}', 'Admin\OrderController@updateproduct')->name('orderproduct.update');
            Route::delete('products/{order_id}/{product_id}', 'Admin\OrderController@productdelete')->name('orderproduct.delete');
            Route::delete('{order_id}', 'Admin\OrderController@orderdelete')->name('orders.delete');
            Route::put('status/{order_id}', 'Admin\OrderController@status')->name('orders.status');
            Route::post('cancel/{flag}', 'Admin\OrderController@cancelorreject')->name('orders.cancel');
            Route::get('order/details/{order_id}', 'Admin\OrderController@show')->name('order_details');
        });


        Route::get('supermarkets/offers/{supermarket_id}', 'Admin\OfferController@supermarketoffers')->name('supermarket.offers');
        Route::get('supermarkets/products/{supermarket_id}/{flag}', 'Admin\ProductController@supermarketproducts')->name('supermarket.products');
        Route::get('supermarkets/branches/{supermarket_id}', 'Admin\BranchController@supermarketbranches')->name('supermarket.branches');
        Route::get('branches/products/{branch_id}/{flag}', 'Admin\ProductController@branchproducts')->name('branch.products');
        Route::get('branches/offers/{branch_id}', 'Admin\OfferController@branchoffers')->name('branch.offers');
/*        Route::get('supermarkets/branches/create/{supermarket_id}', 'Admin\SupermarketController@addbranch')->name('supermarketbranches.create');
        Route::post('supermarkets/branches/store/{supermarket_id}', 'Admin\SupermarketController@storebranch')->name('supermarketbranches.store');
        Route::get('supermarkets/offers/create/{supermarket_id}', 'Admin\SupermarketController@addoffer')->name('supermarketoffers.create');
        Route::post('supermarkets/offers/store/{supermarket_id}', 'Admin\SupermarketController@storeoffer')->name('supermarketoffers.store');
        Route::get('supermarkets/products/create/{supermarket_id}/{flag}', 'Admin\ProductController@create')->name('supermarketproducts.create');
        Route::post('supermarkets/products/store/{supermarket_id}/{flag}', 'Admin\SupermarketController@storeproduct')->name('supermarketproducts.store');
        Route::get('branches/offers/create/{branch_id}', 'Admin\BranchController@addoffer')->name('branchoffers.create');
        Route::post('branches/offers/store/{branch_id}', 'Admin\BranchController@storeoffer')->name('branchoffers.store');
        Route::get('branches/products/create/{branch_id}', 'Admin\BranchController@addproduct')->name('branchproducts.create');
        Route::post('branches/products/store/{branch_id}', 'Admin\BranchController@storeproduct')->name('branchproducts.store');*/

        //system logs
        Route::get('systemlogs', 'Admin\LogController@index')->name('logs.index');

        Route::get('systemlogs/filter/{filter}', 'Admin\LogController@filter')->name('logs.filter');







    });

});


