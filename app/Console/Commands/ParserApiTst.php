<?php

namespace App\Console\Commands;

use App\Services\ParserApiService;
use Illuminate\Console\Command;

class ParserApiTst extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser-api:tst';

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
     * @return int
     */
    public function handle()
    {
        $apiModel = new ParserApiService();

        // $result = $apiModel->getStat();
        $result = $apiModel->getApiData([
            'search' => 1,
            'DateFrom' => '2020-10-16',
            'DateTo' => '2020-11-16',
            'Inn' => 'РОСНЕФТЬ',
            'Court' => 'АС Московской области',
        ]);

        dd($result);
    }
}
