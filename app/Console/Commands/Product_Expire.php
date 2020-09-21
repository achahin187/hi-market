<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class Product_Expire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'deactivate product when match expiration date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $expired_products = Product::where('exp_date',today())->orwhere('end_date',today())->get();

       foreach($expired_products as $product)
       {
           $product->update(['status' => 'inactive']);
       }

    }
}
