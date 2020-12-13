<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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

Route::group(['namespace' => 'Api'], function () {

    Route::post('register', 'AuthController@register')->name('client.register');
    Route::post('login', 'AuthController@login')->name('client.login');
    Route::post('forgetpassword', 'AuthController@forgetpassword')->name('forgetpassword');
    Route::post('verifycode', 'AuthController@verifycode')->name('profile_update');
    Route::post('resetpassword', 'AuthController@resetpassword')->name('reset_password');
    Route::post('changepassword', 'ClientController@changepassword')->name('change_password');
    Route::get('products/search/{name}', 'ProductController@getproductsearch')->name('search');
    Route::post("products/filter", "ProductController@filter");
});

Route::group(['namespace' => 'Api', 'middleware' => 'check_mobile_serial'], function () {

    Route::get('logout', 'AuthController@logout')->name('logout');

    Route::get('products', 'ProductController@index')->name('listproducts');
    Route::post('product', 'ProductController@productdetails')->name('productdetails');
    Route::post("product/count", "ProductController@productCount");
    Route::get('categories', 'CategoriesController@index');
    Route::get('user', 'AuthController@getAuthUser')->name('client.auth');
    Route::get('social/{flag}', 'AuthController@social')->name('social.auth');

    Route::post('profile', 'ClientController@client_profile')->name('client_profile');
    Route::post('profile/update', 'ClientController@updateprofile')->name('profile_update');
    //address
    Route::post('add_address', 'ClientController@add_address')->name('address.store');
    Route::get('get_address/{flag}', 'ClientController@get_address')->name('address.show');
    Route::post("addorder", "OrderController@addorder");
    Route::post("select/date", "OrderController@selectDate");
    Route::post('favourites/add', 'FavouritesController@addfavourite');
//    Route::post('favourites/remove', 'FavouritesController@removefavourites');
    Route::get('clientorders', 'OrderController@clientorders')->name('client_orders');//
    Route::get('order/{order_id}', 'OrderController@getorder')->name('order_details');
    Route::post('cart', 'OrderController@addcart')->name('order_details');
    Route::get("fav/get", "FavouritesController@getfavourites");

    Route::post('getarea', 'LocationController@index')->name('listArea');
    Route::get('gethomedata', 'ProductController@homeData')->name('listHome');
    Route::post('getsupermarketcats', 'CategoriesController@supermarketcategories')->name('listsupermarketcats');
    Route::post('getcategoryproducts', 'CategoriesController@categoryproducts')->name('listcategoryproducts');
    Route::post('supermarketoffers', 'CategoriesController@supermarketoffers')->name('listcategoryproducts');
    Route::post("vendors", "VendorController@show");
    Route::post('clientpoints', 'ClientController@clientpoints')->name('listcategoryproducts');
    Route::get("points/use", "ClientController@usePoints");
    Route::post('clientaddresses', 'ClientController@clientaddresses')->name('listcategoryproducts');
    Route::post("verify/address", "ClientController@validateAddress");

    //sendPromoCode
    Route::post('sendPromoCode', 'CartController@sendPromoCode');

    Route::post('updateaddress', 'ClientController@update_address');
    Route::get("notification", "NotificationController@index");

    //client
    Route::post('update/avatar', 'ClientController@uploadImage');

    //default
    Route::post('set/default', 'ClientController@setDefault');

    //getClientOrder

    Route::get('getClientOrder', 'OrderController@getClientOrder');

});


Route::group(['namespace' => 'Api'], function () {
    //address
    Route::post('deleteAddress', 'ClientController@delete_address');

});
/**
 * Select 2 API
 */
Route::get("select2/categories", "Select2Controller@categories")->name("api.select2.categories");
Route::get("select2/subcategories", "Select2Controller@subcategories")->name("api.select2.subcategories");
Route::get("select2/regions", "Select2Controller@regions")->name("api.select2.regions");
Route::get("select2/restaurants", "Select2Controller@restaurants")->name("api.select2.restaurants");
Route::get("select2/country", "Select2Controller@country")->name("api.select2.country");
Route::get("select2/govern", "Select2Controller@govern")->name("api.select2.govern");
Route::get("select2/products", "Select2Controller@products")->name("api.select2.products");
Route::get("select2/users", "Select2Controller@users")->name("api.select2.users");








