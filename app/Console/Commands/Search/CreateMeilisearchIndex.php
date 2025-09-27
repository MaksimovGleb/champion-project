<?php

namespace App\Console\Commands\Search;

use App\Models\Comment;
use App\Models\Message;
use App\Models\Task;
use App\Models\User;
use Illuminate\Console\Command;
use Meilisearch\Client;

class CreateMeilisearchIndex extends Command
{
    // php artisan scout:import "App\Models\Task"
    // php artisan scout:delete-index "App\Models\Task"
    protected $signature = 'meilisearch:create';

    protected $description = 'Create Meilisearch\'s index and filterable attributes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
//        User::makeAllSearchable();
        Task::makeAllSearchable();
//        Message::makeAllSearchable();
//        Comment::makeAllSearchable();
        return Command::SUCCESS;

    }
}
