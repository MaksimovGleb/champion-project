<?php

namespace App\Console\Commands\Search;

use Illuminate\Console\Command;
use Meilisearch\Client;

class UpdateMeilisearchIndex extends Command
{
    protected $signature = 'meilisearch:update';

    protected $description = 'Update Meilisearch\'s index and filterable attributes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $client = new Client(config('scout.meilisearch.host'));

        $this->updateSortableAttributes($client);

        $this->updateFilterableAttributes($client);

        return Command::SUCCESS;
    }

    protected function updateSortableAttributes(Client $client):void
    {
//        $client->index('Resources')->updateSortableAttributes([
//            'title',
//            'date'
//        ]);

        $this->info('Updated sortable attributes...');
    }

    protected function updateFilterableAttributes(Client $client): void
    {
        $client->index('users')->updateFilterableAttributes([
            'date',
            'type',
            'topics',
            'contributors'
        ]);

        $this->info('Updated filterable attributes...');
    }
}
