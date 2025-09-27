<?php

namespace App\Models;

use App\Traits\NotificationUser\NotificationUserBuilder;
use App\Traits\simpleCRUD;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class NotificationUser extends Model
{
    use simpleCRUD;
    use NotificationUserBuilder;

    protected $fillable = [
        'notification_id',
        'user_id',
        'send_sms',
        'send_email'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
