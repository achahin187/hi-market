<?php

namespace App\Exports;

use App\Supermarket;
use Maatwebsite\Excel\Concerns\FromCollection;

class SuperMarketExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Supermarket::select()->get();
    }
}
