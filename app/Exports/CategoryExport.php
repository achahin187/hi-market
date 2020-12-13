<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::all();
    }

     public function map($registration) : array {
        return [
           	$registration->id,
            $registration->name_ar,
            $registration->name_en,            
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
