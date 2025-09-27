<?php

namespace App\Services\Notifications;

use App\Actions\DefaultNotification\StoreDefaultNotificationAction;
use App\Actions\DefaultNotification\UpdateDefaultNotificationAction;
use App\Actions\NotificationUser\UpdateNotificationUserAction;
use App\Exceptions\HasLastError;
use App\Models\DefaultNotification;
use App\Models\NotificationUser;
use App\Models\User;
use Illuminate\Support\Collection;

class DefaultNotificationService extends HasLastError
{
    private DefaultNotification $defaultNotification;
    private StoreDefaultNotificationAction $actionStoreDefaultNotification;
    private UpdateDefaultNotificationAction $actionUpdateDefaultNotification;
    private UpdateNotificationUserAction $actionUpdateNotificationUser;

    public function __construct(
    ){
        $this->actionStoreDefaultNotification = new StoreDefaultNotificationAction();
        $this->actionUpdateDefaultNotification = new UpdateDefaultNotificationAction();
        $this->actionUpdateNotificationUser = new UpdateNotificationUserAction();
    }

    private function createDefaultNotificationModel(array $defaultNotificationData): self
    {
        $this->setDefaultNotification($this->actionStoreDefaultNotification->execute($defaultNotificationData));
        return $this;
    }

    private function updateDefaultNotificationModel(array $defaultNotificationData): self
    {
        $this->setDefaultNotification($this->actionUpdateDefaultNotification->execute($this->defaultNotification, $defaultNotificationData));
        return $this;
    }

    private function setDefaultNotification(DefaultNotification $defaultNotification): self
    {
        $this->defaultNotification = $defaultNotification;
        return $this;
    }

    public function getDefaultNotification(): DefaultNotification
    {
        return $this->defaultNotification;
    }

    private function updateNotificationUser(array $notificationUserData, User $user): self
    {
        $this->actionUpdateNotificationUser->execute($this->defaultNotification, $user, $notificationUserData);

        return $this;
    }

    public function updateNotificationsUser(
        array $notificationsUserData,
        User $user): ?User
    {
        foreach ($notificationsUserData as $notificationUserData){
            $notificationUserData = (new NotificationUser($notificationUserData))->toArray();
            $this
                ->setDefaultNotification(DefaultNotification::FindOrFail($notificationUserData['notification_id']))
                ->updateNotificationUser($notificationUserData, $user);
        }

        return $user;
    }

    public function createDefaultNotification(
        array $defaultNotificationData): ?DefaultNotification
    {
        try{
            $this
                ->createDefaultNotificationModel($defaultNotificationData);

            return $this->defaultNotification;

        }
        catch (\Exception $exception){
            $this->setLastError($exception->getMessage());
            $this->setTraces($exception->getTraceAsString());
        }
        return null;
    }

    public function updateDefaultNotification(
        DefaultNotification $defaultNotification,
        array $defaultNotificationData): ?DefaultNotification
    {
        try{
            $this
                ->setDefaultNotification($defaultNotification)
                ->updateDefaultNotificationModel($defaultNotificationData);

            return $this->defaultNotification;

        }
        catch (\Exception $exception){
            $this->setLastError($exception->getMessage());
            $this->setTraces($exception->getTraceAsString());
        }
        return null;
    }

    public function createOrUpdate(array $defaultNotificationData, User $user): ?DefaultNotification
    {
        $defaultNotification = DefaultNotification::find($defaultNotificationData['id'] ?? null);

        if ($defaultNotification)
            return $this->updateDefaultNotification($defaultNotification, $defaultNotificationData);

        return $this->createDefaultNotification($defaultNotificationData, $user);
    }

    public function NotificationsUser(User $user, User $who): Collection
    {
        $defaultNotifications = DefaultNotification::where(function ($query) {
            $query->where('edit_sms', true)
                ->orWhere('edit_email', true);
        })->get();

        $notifications_user = $defaultNotifications->map(function ($defaultNotification) use ($user, $who) {
            $userNotification = $who->notificationUsers->firstWhere('notification_id', $defaultNotification->id);

            return [
                'id' => $defaultNotification->id,
                'type_text' => $defaultNotification->type_text,
                'send_sms' => $userNotification->send_sms ?? $defaultNotification->send_sms,
                'send_email' => $userNotification->send_email ?? $defaultNotification->send_email,
                'can_edit_sms' => $defaultNotification->edit_sms && $user->can('notificationSettingsUpdate', [NotificationUser::class, $who]),
                'can_edit_email' => $defaultNotification->edit_email && $user->can('notificationSettingsUpdate', [NotificationUser::class, $who]),
            ];
        });

        return $notifications_user;
    }
}
