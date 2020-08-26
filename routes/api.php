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
        Route::post('favourites/add','FavouritesController@addfavourite');
        Route::get('favourites/{clientid}/{flag}','FavouritesController@getfavourite');

    });





