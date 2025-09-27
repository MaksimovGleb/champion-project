<?php

namespace App\Services;

use App\Contracts\Attachments\AttachmentsCreator;
use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UploadService
{
    /**
     * @param  User  $user Кто прикрепляет
     * @param  array  $files  Пути к прикрепляемым файлам
     * @param  HasMedia  $parent  К какой модели прикрепляем
     * @param  AttachmentsCreator  $attachments  Чем прикрепляем
     * @param  array  $properties - дополнительные свойства
     * @return Collection
     */
    public static function assignFiles(
        User $user,
        array $files,
        HasMedia $parent,
        AttachmentsCreator $attachments,
        array $properties = []
    ): Collection {
        return $attachments->assignFiles(
            $files,
            ['user_id' => (int) $user?->id] + $properties
        );
    }

    public static function updateFiles(
        User $user,
        array $files,
        HasMedia $parent,
        AttachmentsCreator $attachments,
        array $properties = []
    ): Collection {
        return $attachments->updateFiles(
            $files,
            ['user_id' => (int) $user?->id] + $properties
        );
    }

    public static function RemoveByUuid(string $uuid): ?bool
    {
        $media = Media::findByUuid($uuid);

        return $media->delete();
    }
}
