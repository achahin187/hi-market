<?php

namespace App\Console\Commands;

use App\Exports\JsonExport;
use File;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class Collect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collect';
    private $data;
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
        $this->data = collect();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = File::allFiles(public_path("products"));
        foreach ($files as $file)
        {

            $content = json_decode(file_get_contents(public_path("products/" . $file->getBasename())));

            $this->data->add($content[0]);
        }

        Excel::store(new JsonExport,"products.xlsx");

    }
}
