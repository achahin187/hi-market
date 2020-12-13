<?php

namespace App\Exports;

use App\Models\Measures;
use Maatwebsite\Excel\Concerns\FromCollection;

class MeasuresExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Measures::all();
    }


     public function map($registration) : array {
        return [
           	$registration->id,
            $registration->arab_name,
            $registration->eng_name,            
        ] ;
 
 
    }
 
    public function headings() : array {
        return [
            'id',
            'Arabic Name',
			'English Name',
			
        ] ;
    }
}
