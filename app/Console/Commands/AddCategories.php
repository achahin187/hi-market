<?php

namespace App\Console\Commands;


use App\Jobs\FetchProducts;

use Arr;
use GuzzleHttp\Client;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class AddCategories extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var Collection
     */
    private $categories;
    /**
     * @var \Illuminate\Support\Collection
     */
    private $data;
    /**
     * @var array
     */
    private $failedProducts = [];
    private $failedImages = [];
    private $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {


        $this->data = collect();
        $this->client = new Client();
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function handle()
    {
        $data = [
            'device_type' => 'Android',
            'app_version' => '3.61',
            'os_version' => '6.0',
            'warehouse_id' => '',
            'lang_id' => '1',
            'user_id' => '',
        ];

        $response = $this->client->post("https://prod.thegroceryshop.com/web_services14/getCategory", ["body" => json_encode($data)]);//English
//        $cats_ar = $this->addTranslation(CategoryModel::all());
        if (!file_exists(public_path("data"))) {
            mkdir(public_path("data"));
        }
        $this->categories = collect(json_decode($response->getBody()->getContents())->response->data->NestedCategory);
        $this->info("grabbing english categories");
        $this->info($this->categories->count());

//        $this->info(count(json_decode(file_get_contents(public_path("products.json")))));
        foreach ($this->categories as $category) {
            dispatch((new FetchProducts($category))->onQueue("category"));

        }
        file_put_contents(public_path("english_categories.json.json"), json_encode($this->categories));
        $subcategories = $this->categories->filter(function ($cat) {
            return !!$cat;
        });
        file_put_contents(public_path("english_subcategories"), json_encode($subcategories));
        foreach ($subcategories as $subcategory) {
            dispatch((new FetchProducts($subcategory))->onQueue("subcategory"));
        }
        $data["lang"] = 2;
        $cats_ar = $this->client->get("https://prod.thegroceryshop.com/web_services14/getCategory", ["body" => json_encode($data)]);
        file_put_contents(public_path("arabic_categories.json.json"), json_encode($cats_ar));


//        dispatch(new FetchProducts($this->categories[1]));
//
//        foreach ($this->categories as $key => $category) {
//            $r = new Response();
//            $r->category = $category;
//            $products = new ProductFetch(array(
//                'view_by' => '0',
//                'filter' =>
//                    array(
//                        'origin' => '',
//                        'brands' => '',
//                        'selected_lifestyles' => '',
//                        'price' => '',
//                    ),
//                'keyword' => '',
//                'index' => 1,
//                'warehouse_id' => '1',
//                'sort_by' => 'popularity',
//                'category_id' => $category->category_id,
//                'lang_id' => '1',
//                'user_id' => '',
//            ), $this, $category);
//            $fetch = $products->get(1);
//            $this->info("fetching products from category no {$key}");
////dispatch(new FetchProducts($category,$this))->onQueue($key);
////            $this->info("remaining categories " . ($this->categories->count() - $key));
//            foreach ($fetch->data as $products) {
//                foreach ($products as $product) {
//
//                    $productDetails = new ProductDetails(array(
//                        'product_id' => $product->product_id,
//                        'lang_id' => '2',
//                        'user_id' => '',
//                        'warehouse_id' => '1',
//                    ), $this);
//                    $this->info("grabbing product with id: {$product->product_id}");
//                    try {
//
//                        $body = $productDetails->get(2)->body;
//
////                        foreach ($body->File as $index => $file) {
////                            $fileName = time() . ".jpg";
////                            try {
////                                $this->fetch->client->get($file->image, ["sink" => fopen(public_path("data/$fileName"), "w")]);
////
////                            } catch (\Exception $e) {
////                                $this->error("could not fetch image $product->product_id");
////                                $this->failedImages[] = $product->id;
////                            }
////
////                            $body->File[$index]->image = $fileName;
////                        }
//                        $r->products[] = $body;
//                        dump($body);
//                    } catch (\Exception $e) {
//                        $this->info("could not fetch $product->product_id " . $e->getMessage());
//                        $this->failedProducts[] = $product->product_id;
//
//                    }
//
//
//                }
//
//            }
//
//
//            $this->info("grabbing product from category {$category->name}");
//
//            $this->data->add($r);
//        }
//        $products = $this->data->pluck("products")->flatten();
//        file_put_contents(public_path("products.json"), json_encode($products));
//        file_put_contents(public_path("failed_products.json"), json_encode($this->failedProducts));
//        file_put_contents(public_path("failed_images.json"), json_encode($this->failedImages));
//        $categories = collect($this->fetch->get(2));
//
//        file_put_contents(public_path("categories_arabic.json"), json_encode($categories));
//        file_put_contents(public_path("categories_english.json"), json_encode($this->data->pluck("category")));
//        $this->info("products count : {$products->count()}");
//
//        $this->info("Done");
        return 1;
    }

    private function addData()
    {

        $this->info("fetch english data");
        $this->fetch->add($this->categories);
    }

    public function addTranslation($models)
    {
        $cats_ar = $this->fetch->get(2);//Arabic
        for ($i = 0; $i < count($cats_ar); $i++) {

            $this->fetch->translate($models[$i], $cats_ar[$i], "ar");
        }
        return $cats_ar;
    }
}
