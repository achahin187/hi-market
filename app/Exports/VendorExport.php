<?php

namespace App\Exports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\FromCollection;

class VendorExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Vendor::all();
    }

     public function map($registration) : array {
        return [
           	$registration->id,
            $registration->arab_nme,
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
