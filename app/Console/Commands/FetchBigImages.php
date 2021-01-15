<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Mockery\Matcher\Closure;
use parallel\Runtime;

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
        $data = [];
        $products = collect(json_decode(file_get_contents(public_path("products/arabic_products.json"))));

        $self = $this;


        $data = collect();
        foreach ($products as $product) {
            foreach ($product->File as $i => $file) {
                $fileName = time() . uniqid() . ".jpg";
                $self->client->get($file->image, ["sink" => fopen(public_path("data/productdetails/$fileName"), "w")]);
                $product->File[$i]->image = $fileName;
                $this->info("fetch file $fileName from $product->arabic_product_name");
            }
            foreach ($product->FileBig as $i => $file) {
                $fileName = time() . uniqid() . ".jpg";
                $self->client->get($file->image, ["sink" => fopen(public_path("data/productdetails/$fileName"), "w")]);
                $product->FileBig[$i]->image = $fileName;
                $this->info("fetched $fileName file big");
            }
            $data->add($product);
            dump($data);
        }


        file_put_contents(public_path("products/products.json"), json_encode($data));
        return 0;
    }
}
