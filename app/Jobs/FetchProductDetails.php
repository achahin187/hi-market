<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class FetchProductDetails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $product;
    private $client;
    private $data ;

    /**
     * Create a new job instance.
     *
     * @param $product
     */
    public function __construct($product)
    {

        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->client = new Client();
        $this->data= collect();
        $body = array(
            'product_id' => $this->product->product_id,
            'lang_id' => '2',
            'user_id' => '',
            'warehouse_id' => '1',
        );

        $response = $this->client->post("https://prod.thegroceryshop.com/web_services14/product_detail", ["body" => json_encode($body)]);
        $product = json_decode($response->getBody())->response->data->Product;
        dump($product->english_product_name);
        if (!file_exists(public_path("data/productdetails"))) {
            mkdir(public_path("data/productdetails"));
        }
        foreach ($product->File as $index=> $image) {

            $fileName = time().$product->english_product_name.".jpg";
            $this->client->get($image->image, ["sink" =>fopen(public_path("data/productdetails/".(Str::snake($fileName))),"w")]);
            $product->File[$index]->image = $fileName;
            dump($fileName);
        }
        $this->data->add($product);
        if(!file_exists(public_path("products")))
        {
            mkdir(public_path("products"));
        }
        file_put_contents(public_path("products/productdetails" . time() . ".json"), json_encode($this->data));
    }
}
