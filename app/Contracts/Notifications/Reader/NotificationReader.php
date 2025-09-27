<?php

namespace App\Contracts\Notifications\Reader;

use App\Models\DefaultNotification;
use Illuminate\Notifications\DatabaseNotification;

abstract class NotificationReader
{
    public function __construct(protected DatabaseNotification $notification)
    {
    }

    public function getType(): string
    {
        $typeText = DefaultNotification::where('notification_type', $this->notification->type)->value('type_text');
        return $typeText ?? 'НЕИЗВЕСТНЫЙ ТИП';
    }

    abstract public function getText(bool $short = false): string;
    abstract public function getData(): array;
}
