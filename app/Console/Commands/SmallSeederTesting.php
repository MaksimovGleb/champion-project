<?php

namespace App\Console\Commands;

use App\Models\Message;
use App\Models\Role;
use App\Models\Task\Type;
use App\Models\User;
use Database\Factories\TaskFactory;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;

class SmallSeederTesting extends Command
{
    protected $signature = 'users:create';
    //php artisan users:create
    protected $description = 'Создает пользователей с обращениями и сообщениями';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Throwable
     */
    public function handle()
    {
        Event::fake(); // Отключение observer.


            //for ($j = 0; $j < 55; $j++) {
                DB::beginTransaction();
                $this->createUsers(400);
                DB::commit();
                // Очищаем результаты запросов и связи с базой данных
                DB::disconnect();
                \Illuminate\Support\Facades\Cache::flush();
                gc_collect_cycles();
            //}


        Event::spy();

        return null;
    }

    private function createUsers($chunkSize) : void
    {
        $this->info(sprintf("[+] Сначала пользователи"));
        $clients = collect([]);
        $urists = collect([]);

        for ($i = 0; $i < $chunkSize; $i++) {
            try {
                $client = User::factory()
                    ->hasAttached(Role::factory()->client()->count(1)->make())
                    ->create();

                $urist = User::factory()
                    ->hasAttached(Role::factory()->urist()->count(1)->make())
                    ->create();

                $clients->push($client);
                $urists->push($urist);
            } catch (\Exception $exception) {
                $this->info(sprintf("[+] Ошибка создания одного из 2х пользователей на итерации - емэйл совпал или телефон: %d\n", $i));
            }
        }

        $this->info(sprintf("[+] теперь обращения"));
        $newData = [
            "general" => ["stage_id" => "38", "court" => "dddddd", "case_number" => "dddddd"],
            "bfl" => ["stage_id" => "1", "cpo" => null, "consent_sent" => "sdfsd"],
            "tax" => ["stage_id" => "41"]
        ];

        foreach ($clients as $client) {
            foreach (range(1, rand(1, 3)) as $i) {
                $this->createTask($client, $urists->random(), $newData);
            }
        }
        unset($urists);
        unset($clients);
        $this->info(sprintf("[+] Завершено создание пользователей и обращений"));
    }

    private function createTask($client, $urist, $newData) : void
    {
        try {
            $task = (new TaskFactory($client))->create();
            $task->assignClient($client);

            $task->assignType($task?->type?->getFirstLevelParent()?->id ?? Type::StandardTask_id, $newData);

            $task->assignUrist($urist);

            $this->createTaskMessages($urist, $client, $task);
            unset($task);
        } catch (\Exception $exception) {
            $this->info(sprintf("[+] Ошибка создания обращения для клиента: %d\n", $client->id));
            $this->error($exception->getMessage());
        }
    }

    private function createTaskMessages($urist, $client, $task) : void
    {
        $message = Message::factory()->make(['body' => 'Пожалуйста, опишите ситуацию подробнее!']);
        $urist->sendTaskMessage($task, $message);

        foreach (range(1, rand(1, 8)) as $x2) {
            $message = Message::factory()->make();
            if ($x2 % 2) {
                $urist->sendTaskMessage($task, $message);
            } else {
                $client->sendTaskMessage($task, $message);
            }
        }
    }
}
