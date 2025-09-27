<?php

namespace App\Console\Commands;

use App\Enums\TaskStatus;
use App\Events\Task\EventTaskLongService;
use App\Models\Task;
use App\Services\Task\TaskTiming;
use Illuminate\Console\Command;

class MigrateFiles extends Command
{
    protected $signature = 'files:migrate';

    protected $description = 'Помещает существующие файлы обращения в дефолтную папку';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tasks = Task::all();

        foreach ($tasks as $task)
            foreach ($task->attachments() as $attachment)
            {
                $schemeId = $task->getDefaultSchemeId();
                if ($attachment->model_type === Task::class){
                    $attachment->setCustomProperty('task_files_scheme_id', $schemeId);
                    $attachment->save();
                    $this->info(sprintf("task: %d, attachment: %d, scheme_id: %d", $task->id, $attachment->id, $schemeId));
                }
            }

        return 0;
    }
}
