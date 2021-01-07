<?php

namespace App\Exports;

use File;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JsonExport implements FromCollection,WithHeadings
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
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $files = File::allFiles(public_path("products"));
        foreach ($files as $file) {

            $content = json_decode(file_get_contents(public_path("products/" . $file->getBasename())));

            dump($content);
            $this->data->add($content[0]);
        }
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
          "in_wishlist",
          "product_average_rating",
            "product_rating_count",
            "product_id",
            "brand_name",
            "arabic_brand_name",
            "english_brand_name",
            "brand_id",
            "door_step",
            "shipping_hours",
            "offered_price_status",
            "product_acutal_price",
            "product_offer_price",
            "product_offer_percent",
            "offered_start_date",
            "offered_end_date",
            "loyalty_points",
            "delay_shipment",
            "reorder_point",
            "mark_sold_qty",
            "product_name",
            "arabic_product_name",
            "english_product_name",
            "english_product_size",
            "arabic_product_size",
            "product_size",
            "currency",
            "image",
            "is_default",
            "FileBig_image",
            "FileBig_is_default",
            "shipping_third_party",
            "product_rating",
            "saving",
            "product_description",
            "qty",
            "tax"
        ];
    }
}
