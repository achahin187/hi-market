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
        file_put_contents(public_path("english_subcategories.json.json"), json_encode($subcategories));
        foreach ($subcategories as $subcategory) {
            dispatch((new FetchProducts($subcategory))->onQueue("subcategory"));
        }
        $data["lang"] = 2;
        $cats_ar = $this->client->get("https://prod.thegroceryshop.com/web_services14/getCategory", ["body" => json_encode($data)]);
        file_put_contents(public_path("arabic_categories.json.json"), json_encode($cats_ar));

        return 1;
    }


}
