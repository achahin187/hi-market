<?php

namespace App\Imports;

use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsImport implements ToModel, WithHeadingRow
{

    /**
     * @inheritDoc
     */
    public function model(array $row)
    {
        $product = new Product([
            "name_ar" => $row["arabic_product_name"],
            "name_en" => $row["english_product_name"],
            "eng_description" => strip_tags($row["product_description"]),
            "arab_description" => strip_tags($row["product_description"]),


        ]);
        $product->save();
        return $product;
    }

    private function fetchImage($files)
    {
        $client = new Client();
        $files = json_decode($files);

        if (!file_exists(public_path("products/images"))) {
            mkdir(public_path("products/images"));
        }
        $fileName = "";
        foreach ($files as $file) {
            $fileName = time() . ".jpg";
            $client->get($file->image, ["sink" => fopen(public_path("products/images/$fileName"), "w")]);
        }
        return $fileName;
    }


}
