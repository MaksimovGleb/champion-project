<?php

namespace App\Helpers\View;

use App\Models\Payment\Service;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;
use Sopamo\LaravelFilepond\Filepond;

class Html
{
    public static function activeLink($routeName): string
    {
        $result = request()->routeIs($routeName);

        return $result ? 'active' : '';
    }

    public static function activeLinkByUrlMask($mask): string
    {
        $url = request()->url();
        $result = str_contains($url, $mask);

        return $result ? 'active' : '';
    }

    public static function menuOpen($routeName)
    {
        $result = request()->routeIs($routeName);

        return $result ? 'menu-open' : '';
    }

    /**
     * Определяет кол-во курсао
     *
     * @return string
     */
    public static function getCoursesCount(): string
    {
        return 0;
    }

    /**
     * Получает кол-во зарегистрированных пользователей
     *
     * @return string
     */
    public static function getUsersCount(): string
    {
        return User::count();
    }

    /**
     * Удаляем все теги и опасный ввод.
     * Это нужно для корректной работы javascript кода.
     */
    public static function stripReplace($userInput): ?string
    {
        //$userInput = clean($userInput);
        $userInput = strip_tags($userInput);
        $userInput = str_replace('"', "''", $userInput);
        $userInput = str_replace('{{', "{", $userInput);
        $userInput = str_replace('}}', "}", $userInput);
        $userInput = str_replace('\\', "/", $userInput);
        if ($userInput == "")
            return null;
        else
            return $userInput;
    }

    /**
     * Возвращает олды без кавычек и спец символов.
     * Это полезно для JS, чтобы не рушились скрипты
     */
    public static function oldForJs($data)
    {
        $oldValue = old($data);

        if ($oldValue == null)
            return $oldValue;

        if (is_array($oldValue)) {
            array_walk_recursive($oldValue, function (&$userInput, $key) {
                if ($userInput !== null) {
                    $userInput = self::stripReplace($userInput);
                }
            });
        } else {
            $oldValue = self::stripReplace($oldValue);
        }

        if ($oldValue == "")
            return null;
        else
            return $oldValue;
    }

    private static function isFilePathEncrypted($file): bool
    {
        $result = true;
        try {
            app(Filepond::class)->getPathFromServerId($file);
        } catch (DecryptException $exception) {
            $result = false;
        }

        return $result;
    }

    public static function getOldAttachmentsForFilePond_(): string
    {
        $result = [];
        $files = old('file') ?? [];
        $disk = config('filepond.temporary_files_disk', 'local');

        foreach ($files as $file) {
            if (self::isFilePathEncrypted($file)) {
                $file = app(Filepond::class)->getPathFromServerId($file);
            }

            if (str_contains($file, config('filepond.temporary_files_path'))) {
                $result[] = [
                    'source' => $file,
                    'options' => [
                        'type' => 'local',
                        'file' => [
                            'name' => basename($file),
                            'size' => Storage::disk($disk)->size($file),
                        ],
                    ],
                ];
            }
        }

        return json_encode($result);
    }

    public static function getOldAttachmentsForFilePond(): string
    {
        $result = [];
        $files = json_decode(urldecode(old('files_scheme')), true) ?? [];
        $disk = config('filepond.temporary_files_disk', 'local');

        foreach ($files as $i => $fileIlem) {
            $result[$i] = ['scheme_id' => $fileIlem['scheme_id']];
            foreach ($fileIlem['files'] as $file)
            {
                if (str_contains($file, config('filepond.temporary_files_path'))){
                    $result[$i]['source'][] = Storage::disk($disk)->url($file);
                    $result[$i]['options'][] = [
                        'type' => 'local',
                        'file' => [
                            'name' => basename($file),
                            'size' => Storage::disk($disk)->size($file),
                        ]
                    ];
                }
            }
        }
        return urlencode(json_encode($result));
    }

    public static function getUrl(): string
    {
        return env('APP_DEBUG') === true ?
            'https://test.myurist.online/' :
            'https://app.myurist.online/';
    }
}
