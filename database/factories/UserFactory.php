<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\User;
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

    ];
});

$factory->define(product::class, function (Faker $faker) {
    return [
        'arab_name' => $faker->name,
        'eng_name' => $faker->name,
        'description' => $faker->paragraph,
        'rate' => $faker->randomElement([3,4.5,5,4]),
        'price' => $faker->randomElement([30,40]),
        'images' => $faker->randomElement([0,1]),
        'category_id' => Category::all()->random()->id,
        'vendor_id' => Vendor::all()->random()->id,
        'barcode' => $faker->randomElement([30,40])
    ];
});


