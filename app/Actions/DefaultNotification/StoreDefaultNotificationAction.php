<?php

namespace App\Actions\DefaultNotification;

use App\Models\DefaultNotification;

/** Создает настройку уведомлений по умолчанию */
class StoreDefaultNotificationAction
{
    public function execute(array $defaultNotificationData): DefaultNotification
    {
        $defaultNotification = (new DefaultNotification())
            ->setType($defaultNotificationData['notification_type'])
            ->setTypeName((string)$defaultNotificationData['type_name'])
            ->setTypeText((string)$defaultNotificationData['type_text'])
            ->setSMS($defaultNotificationData['send_sms'])
            ->setEditSMS($defaultNotificationData['edit_sms'])
            ->setSMSText((string)$defaultNotificationData['sms_text'])
            ->setEmail($defaultNotificationData['send_email'])
            ->setEditEmail($defaultNotificationData['edit_email'])
            ->setEmailHeader((string)$defaultNotificationData['email_header'])
            ->setEmailText((string)$defaultNotificationData['email_text'])
            ->setEmailFooter((string)$defaultNotificationData['email_footer'])
            ->setReader($defaultNotificationData['reader']);

        $defaultNotification->save();

        return $defaultNotification;
    }
}
