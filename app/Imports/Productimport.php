<?php

namespace App\Imports;

use App\Models\Product;
//use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;
use DB;
class Productimport implements ToModel, WithHeadingRow, WithValidation
{
   
    public function model(array $row)
    {
    	
        $product =  Product::create([
            'name_ar' 			    => $row['product_arabic_name'],
            'name_en' 			    => $row['product_english_name'],
            'eng_description'       => $row['english_description'],
            'arab_description'      => $row['arabic_description'],
            'eng_spec'     			=> $row['english_spec'],
            'arab_spec'     		=> $row['arabic_spec'],
            'price'     			=> $row['price'],
            'offer_price'     		=> $row['offer_price'],
            'rate'     				=> $row['rate'],
            'priority'     			=> $row['priority'],
            'points'     			=> $row['points'],
            'category_id'     		=> $row['category_id'],
            'vendor_id'     		=> $row['vendor_id'],
            'supermarket_id'     	=> $row['supermarket_id'],
            'measure_id'     		=> $row['measure_id'],
            'size_id'     			=> $row['size_id'],
            'flag'     				=> $row['flag'],
            'status'     			=> $row['status'],
            'start_date'    	 	=> $this->ParseDate($row['start_date']),
            'end_date'     			=> $this->ParseDate($row['end_date']),
            //'exp_date'    			=> $this->ParseDate($row['exp_date']),
            //'production_date'     	=> $this->ParseDate($row['production_date']),
            'barcode'     			=> $row['barcode'],
        ]);
      
        
          $branches = explode(',', $row['branches_id']);
          foreach ($branches as $branch) {
              DB::table('product_supermarket')->insert([
                'product_id' => $product->id,
                'branch_id'  => $branch,
              ]);
          }
        return $product;
    }


    private function ParseDate($date)
    {
    	return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date));
    }

    public function rules():array
    {
        return [
            '*.product_arabic_name' => ['required'],
            '*.product_english_name' => ['required'],
        ];
    }
}
          
