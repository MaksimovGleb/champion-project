<?php

namespace App\Actions\DefaultNotification;

use App\Models\DefaultNotification;

/** Обновляет настройку уведомлений умолчанию */
class UpdateDefaultNotificationAction
{
    public function execute(DefaultNotification $defaultNotification,
                            array $defaultNotificationData): DefaultNotification
    {
        $defaultNotification = $defaultNotification
            ->setTypeText((string)$defaultNotificationData['type_text'])
            ->setSMS($defaultNotificationData['send_sms'])
            ->setEditSMS($defaultNotificationData['edit_sms'])
            ->setSMSText((string)$defaultNotificationData['sms_text'])
            ->setEmail($defaultNotificationData['send_email'])
            ->setEditEmail($defaultNotificationData['edit_email'])
            ->setEmailHeader((string)$defaultNotificationData['email_header'])
            ->setEmailText((string)$defaultNotificationData['email_text'])
            ->setEmailFooter((string)$defaultNotificationData['email_footer']);

        $defaultNotification->save();

        return $defaultNotification;
    }
}
