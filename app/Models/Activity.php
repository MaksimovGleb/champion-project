<?php

namespace App\Models;

use App\Enums\LogAction;
use App\Traits\ForHumans;
use App\Traits\Log\Filters;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Activitylog\Models\Activity as BaseActivity;

class Activity extends BaseActivity
{
    use HasUuids, Filters, ForHumans;

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'event',
        'causer_type',
        'causer_id',
        'properties',
        'batch_uuid',
    ];

    protected $with = ['subject', 'causer'];

    protected $casts = [
        'status' => LogAction::class,
    ];
}
