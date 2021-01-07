<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsImport implements ToModel,WithHeadingRow
{

    /**
     * @inheritDoc
     */
    public function model(array $row)
    {
        return new Product([
            ""
        ]);
    }


}
