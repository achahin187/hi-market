<?php

namespace App\Console\Commands;

use App\Exports\ArabicCategoriesExport;
use App\Exports\ArabicSubcategoriesExport;
use App\Exports\CategoriesExport;
use App\Exports\EnglishSubcategoriesExport;
use Illuminate\Console\Command;

class ToExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'to:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        \Excel::store(new CategoriesExport,"english_categories.xlsx");
        \Excel::store(new ArabicCategoriesExport,"arabic_categories.xlsx");
        \Excel::store(new ArabicSubcategoriesExport,"arabic_subcategories.xlsx");
        \Excel::store(new EnglishSubcategoriesExport,"english_subcategories.xlsx");
    }
}
