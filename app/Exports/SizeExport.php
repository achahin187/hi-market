<?php

namespace App\Exports;

use App\Models\Size;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SizeExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Size::all();
    }

     public function map($registration) : array {
        return [
           	$registration->id,
            $registration->value,           
        ] ;
 
 
    }
 
    public function headings() : array {
        return [
            'id',
            'size',
			
			
        ] ;
    }
}
