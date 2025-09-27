<?php

namespace App\Console\Commands;

use App\Enums\TaskStatus;
use App\Events\Task\EventTaskLongService;
use App\Models\Message;
use App\Models\Task;
use App\Models\Task\Type;
use App\Services\Task\TaskTiming;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MigrateFilesFromMessages extends Command
{
    protected $signature = 'files:migrate2';

    protected $description = 'Помещает существующие файлы обращения в дефолтную папку';

    public function __construct()
    {
        parent::__construct();
    }

    public function getDefaultMessageAttachmentSchemeId(Task $task, Media $attachment): ?int
    {
        $client = $task->getTaskFirstClient();
        $user_attached_id = $attachment->getCustomProperty('user_id');
        if ($user_attached_id === $client->id){
            return match ($task->type->getFirstLevelTypeNumber()){
                Type::StandardTask_id => 4,  // Документы обращения->Общие документы->О ситуации
                Type::BFLUTask_id => 193,    // Общие документы->Из переписки->Получено от клиента
                Type::GeneralTask_id => 28,  // Общие документы->Готовые документы->Получено от клиента
                Type::TaxTask_id => 121,     // Общие документы->Готовые документы->Получено от клиента
                default => throw new \Exception("Не поддерживаемый тип обращения!"),
            };
        } else

        return match ($task->type->getFirstLevelTypeNumber()){
            Type::StandardTask_id => 5,  // Документы обращения->Общие документы->Подготовлено юристом
            Type::BFLUTask_id => 190,    // Общие документы->Из переписки->Прочие документы от юриста
            Type::GeneralTask_id => 30,  // Общие документы->Готовые документы->Подготовлено юристом
            Type::TaxTask_id => 123,     // Общие документы->Готовые документы->Подготовлено юристом
            default => throw new \Exception("Не поддерживаемый тип обращения!"),
        };
    }

    public function handle()
    {
        $tasks = Task::all();

        foreach ($tasks as $task)
            foreach ($task->messages as $message)
                foreach ($message->attachments() as $attachment)
                {
                    $schemeId = $this->getDefaultMessageAttachmentSchemeId($task, $attachment);

                    if ($attachment->model_type === Message::class){
                        $attachment->setCustomProperty('task_files_scheme_id', $schemeId);
                        $attachment->save();
                        $this->info(sprintf("task: %d, message_id: %d, attachment: %d, scheme_id: %d",
                            $task->id, $message->id, $attachment->id, $schemeId));
                    }
                }
        return 0;
    }
}
