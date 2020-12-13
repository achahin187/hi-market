<?php

namespace App\Exports;

use App\Models\Supermarket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
class SuperMarketExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Supermarket::with(['area','city','country'])->get();
    }

     public function map($registration) : array {
        return [
            $registration->id,
            $registration->arab_name,
            $registration->eng_name,
            
            // Carbon::parse($registration->event_date)->toFormattedDateString(),
           // Carbon::parse($registration->created_at)->toFormattedDateString()
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
