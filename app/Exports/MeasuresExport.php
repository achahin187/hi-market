<?php

namespace App\Exports;

use App\Models\Measures;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class MeasuresExport implements FromCollection, WithMapping, WithHeadings
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
