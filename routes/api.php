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

    Route::group(['middleware' => ['api'],'namespace' => 'Api'],function () {

        Route::get('products','ProductController@index')->name('listproducts');
        Route::get('products/{id}','ProductController@productdetails')->name('productdetails');
        Route::get('products/search/{name}','ProductController@getproductsearch')->name('search');
        Route::get('categories','CategoriesController@index');
        Route::post('register', 'AuthController@register')->name('client.register');
        Route::post('login', 'AuthController@login')->name('client.login');
        Route::get('logout', 'AuthController@logout')->name('logout');
        Route::get('user', 'AuthController@getAuthUser')->name('client.auth');
        Route::get('social/{flag}', 'AuthController@social')->name('social.auth');

        Route::get('profile/view','ClientController@client_profile')->name('client_profile');
        Route::post('profile/update', 'ClientController@updateprofile')->name('profile_update');
        Route::post('add_address','ClientController@add_address')->name('address.store');
        Route::get('get_address/{flag}', 'ClientController@get_address')->name('address.show');

        Route::post('forgetpassword','AuthController@forgetpassword')->name('forgetpassword');
        Route::post('verifycode', 'AuthController@verifycode')->name('profile_update');
        Route::post('resetpassword', 'ClientController@resetpassword')->name('reset_password');
        Route::post('changepassword', 'ClientController@changepassword')->name('change_password');


        Route::post('add/cv','JobController@add_cv')->name('add_cv');
        Route::get('jobs/view', 'JobController@view_jobs')->name('view_jobs');
        Route::post('jobs/apply', 'JobController@apply_job')->name('apply_job');
        Route::post('favourites/add','FavouritesController@addfavourite');
        Route::get('orders/{client_id}','OrderController@clientorders')->name('client_orders');
        Route::get('order/{order_id}','OrderController@getorder')->name('order_details');


        Route::post('getarea','LocationController@index')->name('listArea');
        Route::get('gethomedata','ProductController@homeData')->name('listHome');
        Route::get('getsupermarketcats','CategoriesController@supermarketcategories')->name('listsupermarketcats');
        Route::get('getcategoryproducts','CategoriesController@categoryproducts')->name('listcategoryproducts');
    });








