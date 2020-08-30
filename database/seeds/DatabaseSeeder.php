<?php

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User', 10)->create();
        factory('App\Models\Category', 10)->create();
        factory('App\Models\Vendor', 10)->create();
        factory('App\Models\Product', 10)->create();
        $clients = factory('App\Models\Client', 10)->create();
        $orders = factory('App\Models\Order', 10)->create();

        foreach ($clients as $client) {
            $products_ids = [];

            $products_ids[] = Product::all()->random()->id;
            $products_ids[] = Product::all()->random()->id;
            $products_ids[] = Product::all()->random()->id;

            $client->products()->sync( $products_ids );
        }

        foreach ($orders as $order) {
            $products_ids = [];

            $products_ids[] = Product::all()->random()->id;
            $products_ids[] = Product::all()->random()->id;
            $products_ids[] = Product::all()->random()->id;

            $order->products()->sync( $products_ids );
        }


        factory('App\Models\Address', 10)->create();

    }
}
