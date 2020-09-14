<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use App\Models\Admin;
use App\Models\CartRequest;
use App\Models\Category;
use App\Models\Client;
use App\Models\Point;
use App\Models\Product;
use App\Models\Reason;
use App\Models\Role;
use App\Models\Setting;
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
        'eng_name' => $faker->name
    ];
});

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'team_id' => Team::all()->random()->id,
        'flag' => $faker->randomElement([0,1]),
        'manager' => $faker->randomElement([0,1]),
    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'arab_name' => $faker->name,
        'eng_name' => $faker->name,
        'image' => $faker->randomElement([0,1]),
    ];
});


$factory->define(Vendor::class, function (Faker $faker) {
    return [
        'arab_name' => $faker->name,
        'eng_name' => $faker->name,
        'image' => $faker->randomElement([0,1]),
        'category_id' => Category::all()->random()->id,
        'sponsor' => $faker->randomElement([0,1]),

    ];
});

$factory->define(Supermarket::class, function (Faker $faker) {
    return [
        'arab_name' => $faker->name,
        'eng_name' => $faker->name,
    ];
});

$factory->define(product::class, function (Faker $faker) {

    $startingDate = $faker->dateTimeBetween('next Monday', 'next Monday +7 days');
    return [
        'arab_name' => $faker->name,
        'eng_name' => $faker->name,
        'arab_description' => $faker->paragraph,
        'eng_description' => $faker->paragraph,
        'price' => $faker->randomElement([30,40]),
        'points' => $faker->randomElement([30,40,10,25,35]),
        'images' => $faker->randomElement([0,1]),
        'category_id' => Category::all()->random()->id,
        'vendor_id' => Vendor::all()->random()->id,
        'supermarket_id' => Supermarket::all()->random()->id,
        'flag' => $faker->randomElement([1,0]),
        'status' => $faker->randomElement(['inactive']),
        'start_date' => $startingDate,
        'end_date' => $faker->dateTimeBetween($startingDate, $startingDate->format('Y-m-d H:i:s').' +2 days')
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
        'mobile_number' => $faker->phoneNumber,
        'unique_id' => $faker->randomNumber(),
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
    return [
        'address' => $faker->address,
        'status' => $faker->randomElement([0,1,2,3,4,5]),
        'client_id' => Client::all()->random()->id,
        'order_price' => $faker->randomElement([30,40]),
        'request' => $faker->randomElement([0,1]),
        'rate' => $faker->randomElement([4.5,5.5,4,5,3.5]),
        'mobile_delivery' => $faker->phoneNumber,
        'comment' => $faker->text,
        'order_price' => $faker->randomElement([50,40,30]),
        'request' => $faker->randomElement([0,1]),
        'approved_at' => $faker->dateTime,
        'prepared_at' => $faker->dateTime,
        'shipping_at' => $faker->dateTime,
        'shipped_at' => $faker->dateTime,
        'cancelled_at' => $faker->dateTime,
        'admin_cancellation' => $faker->randomElement([0,1]),
        'reason_id' => Reason::all()->random()->id,
        'notes' => $faker->text
    ];
});

$factory->define(Point::class, function (Faker $faker) {
    return [
        'from' => $faker->randomElement([100,200,300]),
        'to' => $faker->randomElement([400,500,600]),
        'type' => $faker->randomElement([0,1]),
        'value' => $faker->randomElement([30,40,50]),

    ];
});

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['delivery','admin']),

    ];
});




