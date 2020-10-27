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

        factory('App\Models\Team', 10)->create();

        $this->call([
            PermissionTableSeeder::class,
            CreateAdminSeeder::class
        ]);

        factory('App\Models\Category', 70)->create();

        factory('App\Models\SubCategory', 70)->create();

        factory('App\Models\Measures', 70)->create();

        factory('App\Models\Size', 70)->create();

        factory('App\Models\Vendor', 70)->create();

        $clients = factory('App\Models\Client', 70)->create();

        factory('App\Models\Address', 70)->create();


        factory('App\Models\CartRequest', 70)->create();

        factory('App\Models\Setting', 1)->create();

        factory('App\Models\Reason', 70)->create();

        factory('App\Models\Point', 70)->create();

        factory('App\Models\Supermarket', 70)->create();

        factory('App\Models\Product', 70)->create();

        factory('App\Models\Offer', 70)->create();


        foreach ($clients as $client) {
            $products_ids = [];

            $products_ids[] = Product::all()->random()->id;
            $products_ids[] = Product::all()->random()->id;
            $products_ids[] = Product::all()->random()->id;

            $client->products()->sync( $products_ids );
        }

        $orders = factory('App\Models\Order', 10)->create();

        foreach ($orders as $order) {
            $products_ids = [];

            $products_ids[] = Product::all()->random()->id;
            $products_ids[] = Product::all()->random()->id;
            $products_ids[] = Product::all()->random()->id;

            $order->products()->sync( $products_ids );
        }

        factory('App\Models\Country', 70)->create();

        factory('App\Models\City', 70)->create();

        factory('App\Models\Area', 70)->create();

        factory('App\Models\Coverage_area', 70)->create();



    }
}
