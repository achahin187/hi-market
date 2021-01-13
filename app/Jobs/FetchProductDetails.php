<?php

namespace App\Jobs;

use App\Response\Response;
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
    private $data;
    private $lang;
    private $category;
    private $is_subcategory;

    /**
     * Create a new job instance.
     *
     * @param $product
     * @param $lang
     * @param $category
     * @param $is_subcategory
     */
    public function __construct($product, $lang, $category, $is_subcategory)
    {

        $this->product = $product;
        $this->lang = $lang;
        $this->category = $category;
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
            'product_id' => $this->product->product_id,
            'lang_id' => $this->lang,
            'user_id' => '',
            'warehouse_id' => '1',
        );

        try{

        $response = $this->client->post("https://prod.thegroceryshop.com/web_services14/product_detail", ["body" => json_encode($body)]);
        $product = json_decode($response->getBody())->response->data->Product;

            dump($product->english_product_name);
            if (!file_exists(public_path("data/productdetails"))) {
                mkdir(public_path("data/productdetails"));
            }
            $productResponse = new Response();
            $productResponse->category_id = $this->category->category_id;
            $productResponse->in_wishlist = $product->in_wishlist;
            $productResponse->product_average_rating = $product->product_rating_count;
            $productResponse->product_id = $product->product_id;
            $productResponse->brand_name = $product->brand_name;
            $productResponse->arabic_brand_name = $product->arabic_brand_name;
            $productResponse->english_brand_name = $product->english_brand_name;
            $productResponse->brand_id = $product->brand_id;
            $productResponse->door_step = $product->door_step;
            $productResponse->shipping_hours = $product->shipping_hours;
            $productResponse->is_subcategory = (int)$this->is_subcategory;
            $productResponse->product_acutal_price = $product->product_acutal_price;

            $productResponse->product_offer_price = $product->product_offer_price;
            $productResponse->product_offer_percent = $product->product_offer_percent;
            $productResponse->offered_price_status = $product->offered_price_status;
            $productResponse->offered_start_date = $product->offered_start_date;
            $productResponse->offered_end_date = $product->offered_end_date;
            $productResponse->loyalty_points = $product->loyalty_points;

            $productResponse->delay_shipment = $product->delay_shipment;
            $productResponse->reorder_point = $product->reorder_point;
            $productResponse->mark_sold_qty = $product->mark_sold_qty;
            $productResponse->product_name = $product->product_name;
            $productResponse->arabic_product_name = $product->arabic_product_name;
            $productResponse->english_product_name = $product->english_product_name;
            $productResponse->english_product_size = $product->english_product_size;
            $productResponse->arabic_product_size = $product->arabic_product_size;
            $productResponse->currency = $product->currency;
            $productResponse->product_size = $product->product_size;
            $productResponse->File = $product->File;
            $productResponse->FileBig = $product->FileBig;
            $productResponse->shipping_third_party = $product->shipping_third_party;
            $productResponse->product_rating = $product->product_rating;
            $productResponse->saving = $product->saving;
            $productResponse->product_description = $product->product_description;
            $productResponse->qty = $product->qty;
            $productResponse->tax = $product->tax;

            $this->data->add($productResponse->getAttributes());
            $path = public_path("products/" . ($this->lang == 1 ? "en" : "ar"));
            if (!file_exists($path)) {
                mkdir($path);
            }
            file_put_contents($path . "/" . time() . "products.json", json_encode($this->data));
        }catch (\Exception $e)
        {
            dump("failed to fetch ".$e->getMessage());
        }


    }
}
