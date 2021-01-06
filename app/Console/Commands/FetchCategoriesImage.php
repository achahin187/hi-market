<?php

namespace App\Console\Commands;

use App\Response\Response;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchCategoriesImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categories:image';
    private $client;
    private $categories;
    private $subcategories;
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
        $this->categories = collect();
        $this->subcategories = collect();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arabic_categories = collect(json_decode(file_get_contents(public_path("arabic_categories.json"))));
        $english_categories = collect(json_decode(file_get_contents(public_path("english_categories.json"))));

        $this->fetchCategories($arabic_categories, "arabic_categories.json.json");

        $this->fetchCategories($english_categories, "english_categories.json.json");

        $english_subcategories = $english_categories->pluck("Category")->flatten()->filter(function ($sub) {
            return !is_null($sub);
        });
        $arabic_subcategories = $arabic_categories->pluck("Category")->flatten()->filter(function ($sub) {
            return !is_null($sub);
        });
        $this->fetchSubCategories($arabic_subcategories, "arabic_subcategories.json");
        $this->fetchSubCategories($english_subcategories, "english_subcategories.json");

    }

    public function fetchSubCategories($categories, $exportedFile)
    {
        $data = [];
        foreach ($categories as $subcategory) {
            dump($subcategory);
            $fileName = time() . $subcategory->name . ".jpg";

            $this->client->get($subcategory->image, ["sink" => fopen(public_path("subcategories/$fileName"), "w")]);
            $subcategory->image = $fileName;

            $this->info("image saved:" . $subcategory->name);
          $data[] = $subcategory;
        }
        file_put_contents(public_path($exportedFile), json_encode($data));
        $this->info("subcategories saved: " . $exportedFile);
    }

    public function fetchCategories($categories, $exportedFile)
    {
        $data = [];
        foreach ($categories as $category) {
            $fileName = time() . $category->name . ".jpg";

            $this->client->get($category->image, ["sink" => fopen(public_path("categories/$fileName"), "w")]);
            $category->image = $fileName;
            $this->info("image category saved:" . $category->name);
            $data[] = $category;
        }
        file_put_contents(public_path($exportedFile), json_encode($data));
        $this->info("file saved " . $exportedFile);
    }
}
