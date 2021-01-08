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
    private $lang;

    /**
     * Create a new job instance.
     *
     * @param $product
     * @param $lang
     */
    public function __construct($product,$lang)
    {

        $this->product = $product;
        $this->lang = $lang;
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
            'lang_id' => $this->lang,
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
        $path = public_path("products/".($this->lang == 1 ? "en" : "ar"));
        if(!file_exists($path))
        {
            mkdir($path);
        }

        file_put_contents($path."/". time()."products.json", json_encode($this->data));
    }
}
