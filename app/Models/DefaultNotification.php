<?php

namespace App\Models;

use App\Traits\DefaultNotification\DefaultNotificationBuilder;
use App\Traits\simpleCRUD;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DefaultNotification extends Model
{
    use simpleCRUD;
    use DefaultNotificationBuilder;

    protected $fillable = [
        'id',
        'notification_type',
        'type_name',
        'type_text',
        'send_sms',
        'edit_sms',
        'sms_text',
        'send_email',
        'edit_email',
        'email_header',
        'email_text',
        'email_footer',
        'reader',
    ];

    /** Получаем индивидуальную настройку уведомлений для заданного пользователя для этого типа. */
    public function getNotificationUser(User $user): ?NotificationUser
    {
        return $this->notificationUsers()->where('user_id', $user->id)->first();
    }

    /** Получаем индивидуальные настройки уведомлений для пользователей для этого типа */
    public function notificationUsers(): HasMany
    {
        return $this->hasMany(NotificationUser::class, 'notification_id');
    }
}
