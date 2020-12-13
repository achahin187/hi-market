<?php

namespace App\Imports;

use App\Models\Product;
//use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
class Productimport implements ToModel, WithHeadingRow
{
   
    public function model(array $row)
    {
    	
        return new Product([
            'name_ar' 			    => $row['name_ar'],
            'name_en' 			    => $row['name_en'],
            'eng_description'       => $row['eng_description'],
            'arab_description'      => $row['arab_description'],
            'eng_spec'     			=> $row['eng_spec'],
            'arab_spec'     		=> $row['arab_spec'],
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
            'exp_date'    			=> $this->ParseDate($row['exp_date']),
            'production_date'     	=> $this->ParseDate($row['production_date']),
            'barcode'     			=> $row['barcode'],
        ]);
    }


    private function ParseDate($date)
    {
    	return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date));
    }
}
          
