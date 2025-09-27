<?php

namespace App\Console\Commands\Scout;

use App\Models\Task;
use App\Models\User;
use Illuminate\Console\Command;
use Meilisearch\Client;


class FilterableAttributes extends Command
{
    protected $signature = 'scout:updateFilters';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        User::makeAllSearchable();
        Task::makeAllSearchable();
//         $client->index('users')->updateSearchableAttributes(['id', 'email']);
//         $client->index('users')->updateSortableAttributes(['id']);
//        $client->index('users')->updateFilterableAttributes(['roles']);

//        $client->index('users')->updateSettings([
//            'filterableAttributes' => [
//                'id',
//                'name'
//            ],
//        ]);

    }
}
