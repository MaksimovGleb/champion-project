<?php

namespace App\Services\Log;

use App\Models\Activity;
use App\Models\User;

class LogService
{
    public function get()
    {
        return Activity::query()->orderByDesc('created_at');
    }

    public function getUserLogs($userId)
    {
        return Activity::where('subject_type', User::class)
            ->where('subject_id', $userId)
            ->orderByDesc('created_at');
    }
}
