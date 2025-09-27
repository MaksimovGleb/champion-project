<?php

namespace App\Traits\Notification;

use App\Models\User;
use Illuminate\Support\Carbon;

trait Filters
{
    /**  По ФИО Получателя */
    public static function scopeNameFilter($notifications, $name)
    {
        $splitName = explode(' ', $name, 3);

        if (count($splitName) ==  3)
            $users = User::whereIn('name', $splitName)->whereIn('surname', $splitName)->whereIn('patronymic', $splitName)
                ->orWhereIn('name', $splitName)->whereIn('surname', $splitName)->where('patronymic', null)->pluck('id')->toArray();
        elseif (count($splitName) ==  2)
            $users = User::whereIn('name', $splitName)->whereIn('surname', $splitName)
                ->orWhereIn('name', $splitName)->whereIn('patronymic', $splitName)
                ->orWhereIn('surname', $splitName)->whereIn('patronymic', $splitName)->pluck('id')->toArray();
        else
            $users = User::whereIn('name', $splitName)
            ->orWhereIn('surname', $splitName)
            ->orWhereIn('patronymic', $splitName)->pluck('id')->toArray();

        return $notifications->WhereIn('notifiable_id', $users);
    }

    /** По типу уведомления */
    public static function scopeTypeFilter($notifications, $type_id)
    {
        return $notifications->where('type', $type_id);
    }



    /** По task_id в данных уведомления */
    public static function scopeTaskIdFilter($notifications, $taskId)
    {
        return $notifications->where('data->task_id', $taskId);
    }

    /** По user_id в данных уведомления */
    public static function scopeUserIdFilter($notifications, $userId)
    {
        return $notifications->where('data->user_id', $userId);
    }

    /** По order_id в данных уведомления */
    public static function scopeOrderIdFilter($notifications, $orderId)
    {
        return $notifications->where('data->order_id', $orderId);
    }

    /** По дате создания уведомления */
    public static function scopeDateFilter($notifications, $date)
    {
        if (request()->has('filter.date_enabled_filter')) {
            $date = explode(' - ', urldecode($date));

            $dateFrom = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:00';
            $dateTo = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';

            return $notifications
                ->where('created_at', '>=', $dateFrom)
                ->where('created_at', '<=', $dateTo);
        }
    }

    public static function notificationsFilters($notifications)
    {
        if (array_key_exists('filter', request()->query())) {
            $request = request()->query()['filter'];

            if (array_key_exists('type_filter', $request) && $request['type_filter']!= null)
                $notifications =  self::scopeTypeFilter($notifications,$request['type_filter']);
            if (array_key_exists('name_filter', $request) && $request['name_filter']!= null)
                $notifications = self::scopeNameFilter($notifications, $request['name_filter']);
            if (array_key_exists('task_id_filter', $request) && $request['task_id_filter'] != null)
                $notifications = self::scopeTaskIdFilter($notifications, $request['task_id_filter']);
            if (array_key_exists('user_id_filter', $request) && $request['user_id_filter'] != null)
                $notifications = self::scopeUserIdFilter($notifications, $request['user_id_filter']);
            if (array_key_exists('order_id_filter', $request) && $request['order_id_filter'] != null)
                $notifications = self::scopeOrderIdFilter($notifications, $request['order_id_filter']);
            if (array_key_exists('date_filter', $request) && $request['date_filter']!= null)
                $notifications = self::scopeDateFilter($notifications,$request['date_filter']);
        }
        return $notifications;
    }

    /** Для правильного формата времени по умолчанию */
    public static function dataFilter($notifications = null)
    {
        $dateMin = $dateMax = Carbon::now()->format('d.m.Y');
        if ($notifications->min('created_at') && $notifications->max('created_at')) {
            $dateMin = Carbon::parse($notifications->min('created_at'))->format('d.m.Y');
            $dateMax = Carbon::parse($notifications->max('created_at'))->format('d.m.Y');
        }

        return [$dateMin === $dateMax ? Carbon::parse($dateMin)->subDay()->format('d.m.Y') : $dateMin,
            $dateMax];
    }
}
