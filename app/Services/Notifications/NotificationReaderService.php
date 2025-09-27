<?php

namespace App\Services\Notifications;

use App\Models\DefaultNotification;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Log;

class NotificationReaderService
{
    public function __construct(DatabaseNotification $notification)
    {
        $this->notification = $notification;
    }

    private function getNotificationReader(DatabaseNotification $notification): ?object
    {
        $defaultNotification = DefaultNotification::where('notification_type', $notification->type)->first();

        if ($defaultNotification && $defaultNotification->reader) {
            $readerClass = $defaultNotification->reader;
            return new $readerClass($notification);
        }

        return null;
    }

    public function getNotificationType(): string
    {
        $reader = $this->getNotificationReader($this->notification);
        if ($reader)
            return $reader->getType();

        return 'НЕИЗВЕСТНЫЙ ТИП';
    }

    public function getNotificationText(bool $short = false): string
    {
        try
        {
            $reader = $this->getNotificationReader($this->notification);
            if ($reader)
                return $reader->getText();
        }
        catch (\Exception $exception)
        {
            Log::channel('slack-info')->error('getNotificationText error!',[
                'exception' => $exception->getTraceAsString(),
                'traces' => $exception->getTraceAsString()
            ]);
        }

        return '';
    }

    public function getNotificationData(): array
    {
        try
        {
            $reader = $this->getNotificationReader($this->notification);
            if ($reader)
                return $reader->getData();
        }
        catch (\Exception $exception)
        {
            Log::channel('slack-info')->error('getNotificationData error!',[
                'exception' => $exception->getTraceAsString(),
                'traces' => $exception->getTraceAsString()
            ]);
        }

        return [];
    }

}
