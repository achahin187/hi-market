<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
class ProductsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();

    }

    public function map($registration) : array {
        return [
           
            $registration->name_ar,
            $registration->name_en,
            $registration->eng_description,
            $registration->arab_description,
            $registration->eng_spec,
            $registration->arab_spec,
            $registration->price,
            $registration->offer_price,
            $registration->rate,
            $registration->priority,
            $registration->points,
            $registration->category->name_ar,
            $registration->category->name_en,
            $registration->vendor->arab_name,
            $registration->vendor->eng_name,
            $registration->supermarket->arab_name,
            $registration->supermarket->eng_name,
            $registration->measure->arab_name,
            $registration->measure->eng_name,
            $registration->size->value,
            $registration->flag == 1  ? "offer" : "Not Offer",
           
            Carbon::parse($registration->start_date)->toFormattedDateString(),
            Carbon::parse($registration->end_date)->toFormattedDateString(),
            Carbon::parse($registration->exp_date)->toFormattedDateString(),
            Carbon::parse($registration->production_date)->toFormattedDateString(),
            $registration->barcode,
            Carbon::parse($registration->created_at)->toFormattedDateString(),
            
        ] ;
 
 
    }
 
    public function headings() : array {
        return [
            
            'product Arabic Name',
			'product English Name',
			'English description',
			'Arabic description',
			'English Spec',
			'Arab Spec',
			'price',
			'offer_price',
			'rate',
			'priority',
			'points',
			'category_id',
			'Category English Name',
			'vendor_id',
			'Vendor English Name',
			'supermarket_id',
			'supermarket English Name',
			'measure_id',
			'measure English Name',
			'size_id',
			'flag',
			'start_date',
			'end_date',
            'exp_date',
			'production_date',
            'barcode',
			'created_at',
        ] ;
    }
}
