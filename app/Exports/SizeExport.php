<?php

namespace App\Exports;

use App\Models\Size;
use Maatwebsite\Excel\Concerns\FromCollection;

class SizeExport implements FromCollection
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
            $registration->name_en,            
        ] ;
 
 
    }
 
    public function headings() : array {
        return [
            'id',
            'size',
			
			
        ] ;
    }
}
