<?php

namespace Database\Seeders\Defaults;

use App\Notifications\User\NotificationAccountCreated;
use App\Notifications\User\NotificationAccountCreatedBy;
use App\Notifications\User\NotificationAccountUpdated;
use App\Notifications\User\NotificationPasswordChanged;
use App\Notifications\User\NotificationRecoveryPass;
use App\Services\Notifications\DefaultNotificationService;
use App\Services\Notifications\Readers\NotificationAccountCreatedByReader;
use App\Services\Notifications\Readers\NotificationAccountCreatedReader;
use App\Services\Notifications\Readers\NotificationAccountUpdatedReader;
use App\Services\Notifications\Readers\NotificationPasswordChangedReader;
use App\Services\Notifications\Readers\NotificationRecoveryPassReader;
use Illuminate\Database\Seeder;

class DefaultNotificationSeeder extends Seeder
{
    public function run()
    {
        $defaultNotifications = [
            [
                'notification_type' => NotificationAccountUpdated::class,
                'type_name' => 'Профиль успешно изменен',
                'type_text' => 'Профиль успешно изменен',
                'send_sms' => false,
                'edit_sms' => false,
                'sms_text' => '',
                'send_email' => false,
                'edit_email' => false,
                'email_text' => '',
                'email_header' => '',
                'reader' => NotificationAccountUpdatedReader::class,
            ],
            [
                'notification_type' => NotificationPasswordChanged::class,
                'type_name' => 'Пароль был успешно изменен',
                'type_text' => 'Пароль был успешно изменен',
                'send_sms' => false,
                'edit_sms' => false,
                'sms_text' => '',
                'send_email' => false,
                'edit_email' => false,
                'email_text' => '',
                'email_header' => '',
                'reader' => NotificationPasswordChangedReader::class,
            ],
            [
                'notification_type' => NotificationAccountCreatedBy::class,
                'type_name' => 'Пользователю создали аккаунт',
                'type_text' => 'Пользователю создали аккаунт',
                'send_sms' => true,
                'edit_sms' => false,
                'sms_text' => '',
                'send_email' => true,
                'edit_email' => false,
                'email_text' => '',
                'email_header' => '',
                'reader' => NotificationAccountCreatedByReader::class,
            ],
            [
                'notification_type' => NotificationAccountCreated::class,
                'type_name' => 'Пользователь зарегистрировался',
                'type_text' => 'Пользователь зарегистрировался',
                'send_sms' => true,
                'edit_sms' => false,
                'sms_text' => '',
                'send_email' => true,
                'edit_email' => false,
                'email_text' => '',
                'email_header' => '',
                'reader' => NotificationAccountCreatedReader::class,
            ],
            [
                'notification_type' => NotificationRecoveryPass::class,
                'type_name' => 'Запрошено восстановление пароля',
                'type_text' => 'Запрошено восстановление пароля',
                'send_sms' => false,
                'edit_sms' => false,
                'sms_text' => '',
                'send_email' => true,
                'edit_email' => false,
                'email_text' => '',
                'email_header' => '',
                'reader' => NotificationRecoveryPassReader::class,
            ]
        ];

        $defaultNotificationService = new DefaultNotificationService();

        $footerText = "Данное уведомление сформировано автоматически и не требует ответа.\n" .
            "Вся информация по теме Вашего обращения принимается только в личном кабинете.\n" .
            "Обращаем Ваше внимание, что письмо, направленное на указанный в сообщении электронный адрес, останется без ответа.\n" .
            "С уважением, служба поддержки \"Мой Юрист\".";
        foreach ($defaultNotifications as $notificationData) {
            $notificationData['email_footer'] = $footerText;
            $createdDefaultNotification = $defaultNotificationService->createDefaultNotification($notificationData);

            $this->command->info('[+] создано уведомление по умолчанию: ' . $createdDefaultNotification->notification_type);
        }

        $this->command->info('[+] настройки уведомлений по умолчанию созданы!');

    }
}
