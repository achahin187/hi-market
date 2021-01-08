<?php

namespace App\Console\Commands;

use App\Exports\ArabicCategoriesExport;
use App\Exports\EnglishCategoryExport;
use App\Exports\ProductsJsonExport;
use App\Imports\Productimport;
use App\Imports\ProductsImport;
use App\Models\Category;
use File;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class Collect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collect';
    private $data;
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
        $this->data = collect();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ar_products = File::allFiles(public_path("products/ar"));
        $ar_products_collection = collect();
        foreach ($ar_products as $file) {

            $content = json_decode(file_get_contents(public_path("products/ar/" . $file->getBasename())));

            $ar_products_collection->add($content[0]);
        }
        $en_products = File::allFile(public_path("products/en"));
        $en_products_collection = collect();
        foreach ($en_products as $file) {
            $content = json_decode(file_get_contents(public_path("products/en/" . $file->getBasename())));
            $en_products_collection->add($content[0]);
        }

//        Excel::store(new ProductsJsonExport, "products.xlsx");
//        Excel::store(new EnglishCategoryExport, "english_categories.xlsx");
//        Excel::store(new ArabicCategoriesExport, "arabic_categories.xlsx");
//        Excel::import(new )
        $arabic_categories = json_decode(file_get_contents(public_path("arabic_categories.json.json")));
        $english_categories = json_decode(file_get_contents(public_path("english_categories.json.json")));
        foreach ($arabic_categories as $i => $category) {
            Category::create([
                "name_en" => $english_categories[$i]->name,
                "name_ar" => $category->name,
                "image" => $category->image
            ]);
        }

//        Excel::import(new ProductsImport, storage_path("app/products.xlsx"));

    }


}
