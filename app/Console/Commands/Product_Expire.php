<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
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
       $product = Product::where('exp_date',today())->Where('status', 'active')->orwhere('end_date',today())->first();
        if ($product) {
       
           $product->update(['status' => 'inactive']);
           $sendToAdmins = User::role(['super_admin','supermarket_admin'])->get();
           Notification::send($sendToAdmins,new OrderNotification($product));
        }
      

    }
}
