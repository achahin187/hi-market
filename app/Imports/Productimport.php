<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class Productimport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([

            'name_ar' => $row[0],
            'name_en' => $row[1],
            'eng_description' => $row[2],
            'arab_description' => $row[3],
            'price' => $row[4],
            'barcode' => $row[5],
            'arab_spec' => $row[6],
            'eng_spec' => $row[7]

        ]);
    }
}
