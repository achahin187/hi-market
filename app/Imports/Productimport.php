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
        
        return  new Product([

            'name_ar' => $row[0],
            'name_en' => $row[1],
            'eng_description' => $row[2],
            'arab_description' => $row[3],
            'eng_spec' => $row[4],
            'arab_spec' => $row[5],
            'price' => $row[6],
            'offer_price' => $row[7],
            'rate' => $row[8],
            'priority' => $row[9],
            'points'  => $row[10],
            'category_id'=> $row[11],
           
            'supermarket_id'=> $row[13],
            'measure_id'=> $row[14],
            'size_id'=> $row[15],
            'flag'  => $row[16],
            'status'  => $row[17],
            'start_date'  => $row[18],
            'end_date'  => $row[19],
            'exp_date'=> $row[20],
            'production_date'=> $row[21],
            'barcode' => $row[22],

        ]);

         foreach ($row[12] as  $rows) {
            $product->branches()->sync($rows); 
         }
       
    }
}
          
            