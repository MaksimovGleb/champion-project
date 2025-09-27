<?php

namespace App\Console\Commands;

use App\Enums\TaskStatus;
use App\Events\Task\EventTaskLongService;
use App\Models\Task;
use App\Services\Task\TaskTiming;
use Illuminate\Console\Command;

class TaskTimingChecker extends Command
{
    protected $signature = 'task:check-time';
    //php artisan task:check-time
    protected $description = 'Проверяет все обращения и уведомляет о просроченных';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tasks = Task::whereIn('status',
            [TaskStatus::NEW, TaskStatus::IN_PROGRESS, TaskStatus::CLIENT_ANSWER])->get();

        foreach ($tasks as $task)
            if ($task->timingStatus() == TaskTiming::STATUS_CRITICAL)
            {
                EventTaskLongService::dispatch($task);
            }

        return 0;
    }
}
