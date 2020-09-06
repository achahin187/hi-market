<?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */

    Route::group(['middleware' => ['api','check_lang'],'namespace' => 'Api'],function () {

        Route::get('products','ProductController@index')->name('listproducts');
        Route::get('products/{id}','ProductController@productdetails')->name('productdetails');
        Route::get('products/search/{name}','ProductController@getproductsearch')->name('search');
        Route::get('categories','CategoriesController@index');
        Route::post('favourites/add/{flag}','FavouritesController@addfavourite');
        Route::get('favourites/{clientid}/{flag}','FavouritesController@getfavourites');
        Route::get('orders/{client_id}','OrderController@clientorders')->name('client_orders');
        Route::get('order/{order_id}','OrderController@getorder')->name('order_details');
        Route::get('profile/{client_id}','ClientController@client_profile')->name('client_profile');
        Route::post('addresses/add','ClientController@add_address')->name('add_address');
        Route::get('address/{client_id}','ClientController@get_addresses')->name('client_addresses');
    });

Route::group(['middleware' => ['api','check_lang','CheckClientToken:client-api'],'namespace' => 'Api'],function () {

    Route::get('products','ProductController@index')->name('listproducts');
    Route::get('products/{id}','ProductController@productdetails')->name('productdetails');
    Route::get('products/search/{name}','ProductController@getproductsearch')->name('search');
    Route::get('categories','CategoriesController@index');
    Route::post('favourites/add/{flag}','FavouritesController@addfavourite');
    Route::get('favourites/{clientid}/{flag}','FavouritesController@getfavourites');
    Route::get('orders/{client_id}','OrderController@clientorders')->name('client_orders');
    Route::get('order/{order_id}','OrderController@getorder')->name('order_details');
    Route::get('profile/{client_id}','ClientController@client_profile')->name('client_profile');
    Route::post('addresses/add','ClientController@add_address')->name('add_address');
    Route::get('address/{client_id}','ClientController@get_addresses')->name('client_addresses');
});





