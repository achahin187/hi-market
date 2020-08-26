<?php

use Illuminate\Database\Seeder;

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
    }
}
