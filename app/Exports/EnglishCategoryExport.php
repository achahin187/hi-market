<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EnglishCategoryExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return collect(json_decode(file_get_contents(public_path("english_categories.json.json"))));

    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            "category_id",
            "parent_id",
            "admin_category_level",
            "name",
            "app_ican_id",
            "sequence_number",
            "product_count",
            "image",
            "level",
            "Category"
        ];
    }
}
