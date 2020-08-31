<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use App\Models\Admin;
use App\Models\CartRequest;
use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
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

$factory->define(product::class, function (Faker $faker) {

    $startingDate = $faker->dateTimeBetween('next Monday', 'next Monday +7 days');
    return [
        'arab_name' => $faker->name,
        'eng_name' => $faker->name,
        'arab_description' => $faker->paragraph,
        'eng_description' => $faker->paragraph,
        'rate' => $faker->randomElement([3,4.5,5,4]),
        'price' => $faker->randomElement([30,40]),
        'images' => $faker->randomElement([0,1]),
        'category_id' => Category::all()->random()->id,
        'vendor_id' => Vendor::all()->random()->id,
        'barcode' => $faker->randomElement([30,40]),
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



$factory->define(Order::class, function (Faker $faker) {
    return [
        'address' => $faker->address,
        'status' => $faker->randomElement([0,1]),
        'client_id' => Client::all()->random()->id,
        'order_price' => $faker->randomElement([30,40])
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
    ];
});


