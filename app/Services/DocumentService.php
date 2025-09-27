<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentService
{
    public static $documents_root_dir = 'public/type-documents/';

    public static $documents_storage_dir = '/storage/type-documents/';

    private static function isContains(string $str, string $pos)
    {
        if (! $pos) {
            return true;
        }

        $str = basename(Str::lower($str));
        $pos = trim(Str::lower($pos));

        return Str::contains($str, $pos);
    }

    /**
     * Возвращает количество вложеннных файлов и папок по пути $path
     *
     * @param $path путь к папке
     * @return array ['directory_count'=>, 'file_count' => ]
     */
    public static function countFileAndDirs($path)
    {
        $file_count = 0;
        $directory_count = 0;

        $iterator = new \DirectoryIterator($path);

        foreach ($iterator as $fileinfo) {
            if ($fileinfo->isFile()) {
                $file_count++;
            }

            if ($fileinfo->isDir() and (! $fileinfo->isDot())) {
                $directory_count++;
                $res = self::countFileAndDirs($path.'/'.$fileinfo->getFileName());

                $directory_count += $res['directory_count'];
                $file_count += $res['file_count'];
            }
        }

        $result = ['directory_count' => $directory_count, 'file_count' => $file_count];

        return $result;
    }

    /**
     * Возвращает информацию о файлах в директории.
     *
     * @param $directory
     * @return \Illuminate\Support\Collection
     */
    public static function getFiles($directory): Collection
    {
        $files = collect(Storage::files($directory))
            ->map(function ($file) {
                return [
                    'path' => 'https://cabinet.myurist.online' . Storage::url($file),
                    'shortName' => pathinfo($file, PATHINFO_FILENAME),
                ];
            });

        return $files;
    }

    public static function getDirectories($directory): Collection
    {
        $directories = collect(Storage::directories($directory))
            ->map(function ($dir) {
                $dir = str_replace(self::$documents_root_dir, '', $dir);
                $path = public_path().self::$documents_storage_dir.$dir;
                $counts = DocumentService::countFileAndDirs($path);

                // кодирую слеши в поддирикториях
                $dir = str_replace('/', '|', $dir);
                $dir = route('documents.show', $dir);

                return [
                    'path' => $dir,
                    'shortName' => pathinfo($path, PATHINFO_FILENAME),
                    'directory_count' => $counts['directory_count'],
                    'file_count' => $counts['file_count'],
                ];
            });

        return $directories;
    }

    public static function searchFiles($directory, $filter): Collection
    {
        $files = collect(Storage::allFiles($directory))
            ->filter(function ($value, $key) use ($filter) {
                return self::isContains($value, $filter);
            })
            ->map(function ($file) {
                return [
                    'path' => 'https://cabinet.myurist.online' . Storage::url($file),
                    'shortName' => pathinfo($file, PATHINFO_FILENAME),
                ];
            });

        return $files;
    }

    public static function searchDirectories($directory, $filter): Collection
    {
        $directories = collect(Storage::allDirectories($directory))
            ->filter(function ($value, $key) use ($filter) {
                return self::isContains($value, $filter);
            })
            ->map(function ($dir) {
                $dir = str_replace(self::$documents_root_dir, '', $dir);
                $path = public_path().self::$documents_storage_dir.$dir;
                $counts = DocumentService::countFileAndDirs($path);

                // кодирую слеши в поддирикториях
                $dir = str_replace('/', '|', $dir);
                $dir = route('documents.show', $dir);

                return [
                    'path' => $dir,
                    'shortName' => pathinfo($path, PATHINFO_FILENAME),
                    'directory_count' => $counts['directory_count'],
                    'file_count' => $counts['file_count'],
                ];
            });

        return $directories;
    }
}
