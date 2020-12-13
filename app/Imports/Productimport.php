<?php

namespace App\Imports;

use App\Models\Product;
//use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
class Productimport implements ToModel
{

   public function model(array $row)
    {
       return new Product([

       ]);
    }
}

