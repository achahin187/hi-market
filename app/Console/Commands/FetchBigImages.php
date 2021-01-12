<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchBigImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:images';
    private $client;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = file_get_contents(public_path("products/arabic_products.json"));
        $products = collect(json_decode($products));
        foreach ($products as $product)
        {
            foreach ($product->FileBig as $m)
            {
                $fileName = uniqid().".jpg";
                $this->info("fetching {$m->image}");
                $this->client->get($m->image,["sink"=>fopen(public_path("data/productdetails/$fileName"),"w")]);
                $this->info("fetched: ". $m->image. " and saved file $fileName");
            }
        }
        return 0;
    }
}
