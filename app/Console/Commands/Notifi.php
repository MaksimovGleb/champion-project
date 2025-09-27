<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskNotification;
use Illuminate\Console\Command;

class Notifi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifi:start {x}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Запустить событие. x - номер события';

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
        // php artisan notifi:start 1
        $x = $this->argument('x');
        switch ($x) {
            case 1:
                //$task = Tasks::find(1);
                $task = Task::all()->random();
                $user = User::Find(5);
                $user->notify(new TaskNotification($task, 'test'));
                echo "Sended task_id: $task->id, to user: $user->id";
                break;
            default:
                echo "$x - не известный номер события!";
        }
    }
}
