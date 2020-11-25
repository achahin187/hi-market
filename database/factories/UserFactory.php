default<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use App\Models\Area;
use App\Models\Branch;
use App\Models\CartRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use App\Models\Coverage_area;
use App\Models\Measures;
use App\Models\Offer;
use App\Models\Point;
use App\Models\Product;
use App\Models\Reason;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\Supermarket;
use App\Models\Team;
use App\User;
use App\Models\Order;
use App\Models\Vendor;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(Team::class, function (Faker $faker) {
    return [
        'arab_name' => $faker->name,
        'eng_name' => $faker->name,
        'arab_description' => $faker->paragraph,
        'eng_description' => $faker->paragraph,
        'role_id' => 1,
        'created_by' => 1,
        'updated_by' => 1
    ];
});


$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('123456789'),//'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'team_id' => Team::all()->random()->id,
        'flag' => $faker->randomElement([0,1]),
        //'manager' => $faker->randomElement([0,1]),
        'created_by' => 1,
        'updated_by' => 1
    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name_ar' => $faker->name,
        'name_en' => $faker->name,
        'image' => 'category.png',
        'created_by' => User::all()->random()->id,
        'updated_by' => User::all()->random()->id
    ];
});

$factory->define(Branch::class, function (Faker $faker) {
    return [
        'name_ar' => $faker->name,
        'name_en' => $faker->name,
        'status' => $faker->randomElement(['inactive','active']),
        'supermarket_id' => Supermarket::all()->random()->id,
        'created_by' => User::all()->random()->id,
        'updated_by' => User::all()->random()->id
    ];
});

$factory->define(SubCategory::class, function (Faker $faker) {
    return [
        'arab_name' => $faker->name,
        'eng_name' => $faker->name,
        'image' => $faker->randomElement([0,1]),
        'category_id' => Category::all()->random()->id,
        'created_by' => User::all()->random()->id,
        'updated_by' => User::all()->random()->id
    ];
});


$factory->define(Vendor::class, function (Faker $faker) {
    return [
        'arab_name' => $faker->name,
        'eng_name' => $faker->name,
        'image' => $faker->randomElement([0,1]),
        'category_id' => Category::all()->random()->id,
        'subcategory_id' => SubCategory::all()->random()->id,
        'sponsor' => $faker->randomElement([0,1]),
        'created_by' => User::all()->random()->id,
        'updated_by' => User::all()->random()->id

    ];
});



$factory->define(Measures::class, function (Faker $faker) {
    return [
        'arab_name' => $faker->name,
        'eng_name' => $faker->name,
        'created_by' => User::all()->random()->id,
        'updated_by' => User::all()->random()->id
    ];
});

$factory->define(Size::class, function (Faker $faker) {
    return [
        'value' => $faker->randomElement(['1x24','1x10','1','2','3.5','5','10']),
        'created_by' => User::all()->random()->id,
        'updated_by' => User::all()->random()->id
    ];
});

$factory->define(Country::class, function (Faker $faker) {
    return [
        'name_ar' => $faker->country,
        'name_en' => $faker->country,
        'numcode' => $faker->randomNumber(),
        'phonecode' => $faker->randomNumber(),
        'phonelength' => $faker->randomNumber(),
        'status' => $faker->randomElement(['active','inactive']),
    ];
});

$factory->define(City::class, function (Faker $faker) {
    return [
        'name_ar' => $faker->city,
        'name_en' => $faker->city,
        'country' => Country::all()->random()->id,
        'status' => $faker->randomElement(['active','inactive']),
    ];
});

$factory->define(Area::class, function (Faker $faker) {
    return [
        'name_ar' => $faker->address,
        'name_en' => $faker->address,
        'country' => Country::all()->random()->id,
        'city' => City::all()->random()->id,
        'status' => $faker->randomElement(['active','inactive']),
    ];
});

$factory->define(Supermarket::class, function (Faker $faker) {
    return [
        'arab_name' => $faker->name,
        'eng_name' => $faker->name,
        'status' => $faker->randomElement(['inactive','active']),
        'state' => $faker->randomElement(['open','closed']),
        'start_time' => $faker->time('h:i').'PM',
        'end_time' => $faker->time('h:i').'PM',
        'image' => 'image.png',
        'logo_image' => 'logo.png',
        'area_id' => Area::all()->random()->id,
        'city_id' => City::all()->random()->id,
        'country_id' => Country::all()->random()->id,
        'priority' => $faker->numberBetween(1,50),
        'commission' => $faker->randomElement([10.5,10.6,15,20,25,35]),
        'created_by' => User::all()->random()->id,
        'updated_by' => User::all()->random()->id
    ];
});

$factory->define(product::class, function (Faker $faker) {

    $startingDate = $faker->dateTimeBetween('next Monday', 'next Monday +7 days');
    return [
        'name_ar' => $faker->name,
        'name_en' => $faker->name,
        'arab_description' => $faker->paragraph,
        'eng_description' => $faker->paragraph,
        'arab_spec' => $faker->paragraph,
        'eng_spec' => $faker->paragraph,
        'price' => $faker->randomElement([30,40]),
        'offer_price' => $faker->randomElement([10,5,15,20]),
        'rate' => $faker->randomElement([4.5,5.5,4,5,3.5]),
        'ratings' => 172,
        'points' => $faker->randomElement([30,40,10,25,35]),
        'priority' => $faker->numberBetween(1,50),
        'barcode' => $faker->randomNumber(),
        'images' => 'product.png',
        'category_id' => Category::all()->random()->id,
        'vendor_id' => Vendor::all()->random()->id,
        'supermarket_id' => Supermarket::all()->random()->id,
        'branch_id' => Branch::all()->random()->id,
        'subcategory_id' => SubCategory::all()->random()->id,
        'measure_id' => Measures::all()->random()->id,
        'size_id' => Size::all()->random()->id,
        'flag' => $faker->randomElement([1,0]),
        'status' => $faker->randomElement(['inactive','active']),
        'start_date' => $startingDate,
        'end_date' => $faker->dateTimeBetween($startingDate, $startingDate->format('Y-m-d').' +2 days'),
        'production_date' => $startingDate,
        'exp_date' => $faker->dateTimeBetween($startingDate, $startingDate->format('Y-m-d').' +2 days'),
    ];
});

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'total_points' => $faker->randomElement([100,200,300,400]),
        'address' => $faker->address,
        'image' => 'mohamed.jpg',
        'mobile_number' => $faker->phoneNumber,
        'remember_token' => Str::random(10),
    ];
});



$factory->define(Address::class, function (Faker $faker) {
    return [
        'description' => $faker->paragraph,
        'client_id' => Client::all()->random()->id,
    ];
});

$factory->define(CartRequest::class, function (Faker $faker) {
    return [
        'cart_description' => $faker->paragraph,
        'client_id' => Client::all()->random()->id,
        'address' => $faker->address,
        'converted' => $faker->randomElement([0,1])
    ];
});

$factory->define(Setting::class, function (Faker $faker) {
    return [
        'tax' => $faker->randomElement([0,1]),
        'tax_value' => $faker->randomNumber([5.55,10.55]),
        'tax_on_product' => $faker->randomElement([0,1]),
        'delivery' => $faker->randomNumber([5,10]),
        'cancellation' => $faker->randomElement([0,1])
    ];
});

$factory->define(Reason::class, function (Faker $faker) {
    return [
        'eng_reason' => $faker->text,
        'arab_reason' => $faker->text,
        'status' => $faker->randomElement(['active','inactive']),
    ];
});


$factory->define(Order::class, function (Faker $faker) {

    $startingDate = $faker->dateTimeBetween('next Monday', 'next Monday +7 days');
    return [

        'address' => $faker->address,
        'status' => $faker->randomElement([0,1,2,3,4,5]),
        'delivery_date' => $startingDate,
        'delivery_rate' => $faker->randomElement([3.5,5,4,3]),
        'client_id' => Client::all()->random()->id,
        'order_price' => $faker->randomElement([30,40]),
        'request' => $faker->randomElement([0,1]),
        'rate' => $faker->randomElement([4.5,5.5,4,5,3.5]),
        'mobile_delivery' => $faker->phoneNumber,
        'client_review' => $faker->text,
        
        'approved_at' => $faker->dateTime,
        'prepared_at' => $faker->dateTime,
        'shipping_at' => $faker->dateTime,
        'shipped_at' => $faker->dateTime,
        'rejected_at' => $faker->dateTime,
        'received_at' => $faker->dateTime,
        'cancelled_at' => $faker->dateTime,
        'admin_cancellation' => $faker->randomElement([0,1]),
        'reason_id' => Reason::all()->random()->id,
        'notes' => $faker->text
    ];
});

$factory->define(Point::class, function (Faker $faker) {

    $startingDate = $faker->dateTimeBetween('next Monday', 'next Monday +7 days');
    return [
        'points' => $faker->randomElement([25,50,100,200,300]),
        'offer_type' => $faker->randomElement(['value','percentage']),
        'type' => $faker->randomElement([0,1]),
        'value' => $faker->randomElement([30,40,50]),
        'status' => $faker->randomElement(['inactive','active']),
        'start_date' => $startingDate,
        'end_date' => $faker->dateTimeBetween($startingDate, $startingDate->format('Y-m-d').' +2 days'),

    ];
});

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['delivery','admin']),

    ];
});

$factory->define(Offer::class, function (Faker $faker) {

    $startingDate = $faker->dateTimeBetween('next Monday', 'next Monday +7 days');

    return [

        'arab_name' => $faker->name,
        'eng_name' => $faker->name,
        'arab_description' => $faker->paragraph,
        'eng_description' => $faker->paragraph,
        'promocode' => 'sjd123',
        'value_type' => $faker->randomElement(["free delivery","discount by percentage","free product","discount by value"]),
        'offer_type' => $faker->randomElement(["promocode","navigable"]),
        'supermarket_id' => Supermarket::all()->random()->id,
        'branch_id' => Branch::all()->random()->id,
        'status' => $faker->randomElement(['inactive','active']),
        'image' => 'offer.png',
        'start_date' => $startingDate,
        'end_date' => $faker->dateTimeBetween($startingDate, $startingDate->format('Y-m-d').' +2 days'),

    ];
});

$factory->define(\App\Models\Notification::class, function (Faker $faker) {
    return [
        'arab_title' => $faker->name,
        'eng_title' => $faker->name,
        'arab_body' => $faker->paragraph,
        'eng_body' => $faker->paragraph,
        'icon' => "12.jpg",
        'flag' => $faker->randomElement([0,1,2])
    ];
});


$factory->define(Coverage_area::class, function (Faker $faker) {
    return [
        'lat' => $faker->randomNumber(['32.5','37.2','31.3']),
        'long' => $faker->randomElement(['34.5','35.2','36.12']),
        'status' => $faker->randomElement(['active','inactive']),
    ];
});






