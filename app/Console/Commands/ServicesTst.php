<?php

namespace App\Console\Commands;

use App\Mail\Log\NewErrorLog;
use App\Services\Post\Dadata;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ServicesTst extends Command
{
    protected $signature = 'services:tst';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        return 0;
        $failures = [];
        $services = [];
        $services['dadata'] = new Dadata();

        foreach ($services as $serviceName => $service) {
            if ($service->test()) {
                echo $serviceName." : OK\n\r";
            } else {
                echo $serviceName." : ERROR\n\r";
                $failures[$serviceName] = $service->getMessage();
            }
        }

        if (count($failures)) {
            $this->sendMessages($failures);
        } else {
            Log::channel('slack-info')->info('Все сервисы работают в штатном режиме!');
        }
    }

    private function sendMessages(array $failures)
    {
        Log::channel('slack-info')->emergency($failures);
        Log::channel('slack-errors')->emergency($failures);
        Mail::to(config('mail.task_log_mail'))->queue(new NewErrorLog($failures));
    }
}
