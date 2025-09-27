<?php

namespace App\Services\Statistics;

use App\Models\User;
use Carbon\Carbon;

class StatisticsService
{
    public function NewUsers(int $days = 1): array
    {
        $result = [];
        $endDate = Carbon::now(); // Сегодняшняя дата
        $userCounts = [];
        $commonCounts = 0;

        for ($i = 0; $i < $days; $i++) {
            $date = $endDate->copy()->subDays($i)->toDateString();
            $count = User::whereDate('created_at', '=', $date)->count();
            $userCounts[$date] = $count;
            $commonCounts += $count;
        }
        $result['day_stats'] = $userCounts;
        $result['common'] = $commonCounts;
        return $result;
    }
}
