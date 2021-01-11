<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:categories';
    private $client;
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
        $this->client = new Client();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $data = [
            'device_type' => 'Android',
            'app_version' => '3.61',
            'os_version' => '6.0',
            'warehouse_id' => '',
            'lang_id' => '2',
            'user_id' => '',
        ];
        $cats_ar = $this->client->post("https://prod.thegroceryshop.com/web_services14/getCategory", ["body" => json_encode($data)]);
        dump($cats_ar->getBody()->getContents());
        file_put_contents(public_path("arabic_categories.json.json"), json_encode($cats_ar->getBody()->getContents()));
        return 0;
    }
}
