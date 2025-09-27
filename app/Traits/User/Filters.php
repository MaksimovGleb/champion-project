<?php

namespace App\Traits\User;

use App\Enums\OrderStatus;
use App\Enums\UserMarked;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

trait Filters
{
    /** По ФИО пользователя */
    public function scopeNameFilter(Builder $query, $name)
    {
        $splitName = explode(' ', $name, 3);

        if (count($splitName) ==  3)
            return $query
                ->whereIn('name', $splitName)->whereIn('surname', $splitName)->whereIn('patronymic', $splitName)
                ->orWhereIn('name', $splitName)->whereIn('surname', $splitName)->where('patronymic', null);
        if (count($splitName) ==  2)
            return $query
                ->whereIn('name', $splitName)->whereIn('surname', $splitName)
                ->orWhereIn('name', $splitName)->whereIn('patronymic', $splitName)
                ->orWhereIn('surname', $splitName)->whereIn('patronymic', $splitName);
        return $query
            ->whereIn('name', $splitName)
            ->orWhereIn('surname', $splitName)
            ->orWhereIn('patronymic', $splitName);

    }

    /** По email пользователя */
    public function scopeEmailFilter(Builder $query, $email)
    {
        $query->where('email', 'like', "%$email%");
    }

    /** По телефону пользователя */
    public function scopePhoneFilter(Builder $query, $phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if ($phone[0] == '8') {
            $phone[0] = '7';
        }

        $query->where('phone', 'like', "%$phone%");
    }

    /** По статусам обращений пользователя */
    public function scopeTasksStatusFilter(Builder $query, $status)
    {
        $role = request()->route('role') ?? new Role();
        $statuses = request()->input('filter.tasks_status_filter');

        switch ($role) {
            default:
                return $query->whereHas('allMyTasks', function ($query) use ($statuses) {
                    $query->whereIn('tasks.status', $statuses);
                });
        }
    }

    /** По дате регистрации пользователя */
    public function scopeDateFilter(Builder $query, $date)
    {
        if (request()->has('filter.date_enabled_filter')) {
            $date = explode(' - ', urldecode($date));

            $dateFrom = isset($date[0]) ? Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:00' : null;
            $dateTo = isset($date[1]) ? Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59' : null;

            if ($dateFrom) {
                $query->where('users.created_at', '>=', $dateFrom);
            }

            if ($dateTo) {
                $query->where('users.created_at', '<=', $dateTo);
            }
        }
    }

    public static function usersFilters($users)
    {
        return QueryBuilder::for($users)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::scope('name_filter'),
                AllowedFilter::scope('email_filter'),
                AllowedFilter::scope('phone_filter'),
                AllowedFilter::scope('date_filter'),

            ]);
    }

    public static function dataFilter()
    {
        $dateMin = $dateMax = Carbon::now()->format('d.m.Y');
        if (User::count()) {
            $dateMin = Carbon::parse(User::min('created_at'))->format('d.m.Y');
            $dateMax = Carbon::parse(User::max('created_at'))->format('d.m.Y');
        }

        return [$dateMin === $dateMax ? Carbon::parse($dateMin)->subDay()->format('d.m.Y') : $dateMin,
            $dateMax];
    }
}
