<?php

namespace App\Console\Commands;

use App\Exports\ArabicCategoriesExport;
use App\Exports\EnglishCategoryExport;
use App\Exports\ProductsJsonExport;
use App\Imports\Productimport;
use App\Imports\ProductsImport;
use App\Models\Branch;
use App\Models\Category;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
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
        $this->info("processing :" . count($ar_products) . " product");
        foreach ($ar_products as $file) {

            $content = json_decode(file_get_contents(public_path("products/ar/" . $file->getBasename())));

            $ar_products_collection->add($content[0]);
        }
        file_put_contents(public_path("products/arabic_products.json"), json_encode($ar_products_collection));
        $this->info("fetched arabic products " . $ar_products_collection->count() . " product");
        $en_products = File::allFiles(public_path("products/en"));
        $this->info("processing :" . count($en_products) . " product");
        $en_products_collection = collect();
        foreach ($en_products as $file) {
            $content = json_decode(file_get_contents(public_path("products/en/" . $file->getBasename())));
            $en_products_collection->add($content[0]);
        }
        file_put_contents(public_path("products/english_products.json"), json_encode($en_products_collection));
        $this->info("fetched english products " . $en_products_collection->count() . " product");
        $arabic_categories = json_decode(file_get_contents(public_path("arabic_categories.json.json")));
        $english_categories = json_decode(file_get_contents(public_path("english_categories.json.json")));
//        Excel::store(new ArabicCategoriesExport, "arabic_categories.xlsx");


        Excel::store(new ProductsJsonExport, "products.xlsx");
//        Excel::store(new EnglishCategoryExport, "english_categories.xlsx");
//        Excel::store(new ArabicCategoriesExport, "arabic_categories.xlsx");
//        Excel::import(new )


//        Excel::import(new ProductsImport, storage_path("app/products.xlsx"));

    }


}
