<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class EnglishSubcategoriesExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $file = json_decode(file_get_contents(public_path("english_subcategories.json")));
        return collect($file);
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
            "app_icon_id",
            "sequence_number",
            "product_count",
            "image",
            "level"

        ];
    }
}
