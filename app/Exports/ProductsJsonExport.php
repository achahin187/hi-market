<?php

namespace App\Exports;

use App\Response\Response;
use File;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsJsonExport implements FromCollection, WithHeadings
{
    /**
     * @var Collection
     */
    private $data;

    public function __construct()
    {
        $this->data = collect();
    }


    /**
     * @return Collection
     */
    public function collection()
    {
        $files_en = collect(File::allFiles(public_path("products/en")));
        $files_ar = collect(File::allFiles(public_path("products/ar")));

        foreach ($files_ar as $index => $file) {

            $content = json_decode(file_get_contents($file->getRealPath()))[0];
            $content_ar = json_decode(file_get_contents($files_ar[$index]->getRealPath()))[0];
            if (isset($content->status)) {
                continue;
            }
//dump($content->cate);
            if (isset($content->category_id) && isset($content_ar->category_id)) {
                dump($file->getRealPath());
                $response = new Response();
                $response->category_id = $content->category_id;
                $response->in_wishlist = $content->in_wishlist;
                $response->product_average_rating = $content->product_average_rating;

                $response->arabic_brand_name = $content->arabic_brand_name;
                $response->product_id = $content->product_id;
                $response->brand_name = $content->brand_name;
                $response->arabic_brand_name = $content->arabic_brand_name;
                $response->english_brand_name = $content->english_brand_name;
                $response->brand_id = $content->brand_id;
                $response->door_step = $content->door_step;
                $response->is_subcategory = $content->is_subcategory;
                $response->product_acutal_price = $content->product_acutal_price;
                $response->product_offer_price = $content->product_offer_price;
                $response->offered_price_status = $content->offered_price_status;
                $response->offered_start_date = $content->offered_start_date;
                $response->offered_end_date = $content->offered_end_date;
                $response->loyalty_points = $content->loyalty_points;
                $response->delay_shipment = $content->delay_shipment;
                $response->reorder_point = $content->reorder_point;
                $response->mark_sold_qty = $content->mark_sold_qty;
                $response->product_name = $content->product_name;
                $response->product_offer_percent = $content->product_offer_percent;
                $response->arabic_product_name = $content->arabic_product_name;
                $response->english_product_name = $content->english_product_name;
                $response->english_product_size = $content->english_product_size;
                $response->arabic_product_size = $content->arabic_product_size;
                $response->product_size = $content->product_size;
                $response->currency = $content->currency;
                $response->File = $content->File;
                $response->FileBig = $content->FileBig;
                $response->shipping_third_party = $content->shipping_third_party;
                $response->product_rating = $content->product_rating;
                $response->saving = $content->saving;
                $response->product_description_en = $content->product_description;
                $response->product_description_ar = $content_ar->product_description;
                $response->qty = $content->qty;
                $response->tax = $content->tax;
                dump($response->getAttributes());
                $this->data->add($response->getAttributes());

            } else {
                dump($content);

            }


        }

        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            "category_id",
            'in_wishlist',
            'product_average_rating',
            'product_id',
            'brand_name',
            'arabic_brand_name',
            'english_brand_name',
            'brand_id',
            'door_step',
            'offered_price_status',
            'product_acutal_price',
            'product_offer_price',
            'product_offer_percent',
            'offered_start_date',
            'offered_end_date',
            'loyalty_points',
            'delay_shipment',
            'reorder_point',
            'mark_sold_qty',
            'product_name',
            'arabic_product_name',
            'english_product_name',
            'english_product_size',
            'arabic_product_size',
            "product_size",
            "is_subcategory",
            'currency',
            'File',
            'FileBig',
            'shipping_third_party',
            'product_rating',
            'saving',
            'product_description_en',
            'product_description_ar',
            'qty',
            'tax',
        ];

    }
}
