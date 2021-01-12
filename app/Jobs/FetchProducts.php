<?php

namespace App\Jobs;


use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $category;
    /**
     * @var Client
     */
    private $client;
    /**
     * @var \Illuminate\Support\Collection
     */
    private $data;
    private $index = 0;
    private $lang;
    private $is_subcategory;

    /**
     * Create a new job instance.
     *
     * @param $category
     * @param $lang
     * @param $is_subcategory
     */
    public function __construct($category,$lang,$is_subcategory)
    {
        //
        $this->category = $category;


        $this->lang = $lang;
        $this->is_subcategory = $is_subcategory;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->client = new Client();
        $this->data = collect();
        $body = array(
            'view_by' => '0',
            'filter' =>
                array(
                    'origin' => '',
                    'brands' => '',
                    'selected_lifestyles' => '',
                    'price' => '',
                ),
            'keyword' => '',
            'index' => 1,
            'warehouse_id' => '1',
            'sort_by' => 'popularity',
            'category_id' => $this->category->category_id,
            'lang_id' => $this->lang,
            'user_id' => '',
        );
        $data = $this->fetch($body);
        if (!file_exists(public_path("products"))) {
            mkdir(public_path("products"));
        }

    }

    public function fetch($body)
    {
        $response = $this->client->post("https://prod.thegroceryshop.com/web_services14/getCategoryProduct", ["body" => json_encode($body)]);
        $products = json_decode($response->getBody())->response->data->Product;
        foreach ($products as $product) {
            dump("product with id :" . $product->product_id);

//            $fileName = time() . "{$this->category->name}.jpg";

//            $this->client->get($product->image, ["sink" => fopen(public_path("data/$fileName"), "w")]);
//            $product->image = $fileName;
            dispatch(new FetchProductDetails($product,$this->lang,$this->category,$this->is_subcategory))->onQueue("products");
            $this->data->add($product);

        }
        if (count($products)) {
            dump(count($products));
            $body["index"] = $this->index++;
            dump($body["index"]);
            $this->fetch($body);

        }

    }
}
