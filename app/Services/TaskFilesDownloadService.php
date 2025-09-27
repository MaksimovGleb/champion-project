<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskFilesScheme;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use ZipArchive;

class TaskFilesDownloadService
{
    private string $zipArchiveFolder = "tmp";

    public function __construct()
    {
        $zipArchiveFolderPath = storage_path($this->zipArchiveFolder);
        if (!file_exists($zipArchiveFolderPath))
            mkdir(storage_path($zipArchiveFolderPath));
    }

    private function sanitizingFileName(string $path): string
    {
        return strtolower(str_replace(['#', '/'], '-', $path));
    }

    public function getCorrectFileName(Media $file, TaskFilesScheme $scheme,
                                        int $index = 0, bool $isFileSingleInGroup = false): string
    {
        // Определяем расширение файла
        $extension = pathinfo($file->getPath(), PATHINFO_EXTENSION);

        // Определяем имя файла
        $filename = $scheme->name;

        if (!$isFileSingleInGroup)
            $filename .= '_' . ($index + 1);

        // Форматируем имя файла с расширением
        return sprintf('%s.%s', $filename, $extension);
    }

    private function getAllFilesGroupFromNode(TaskFilesScheme $node): Collection
    {
        $result = collect();

        foreach ($node->children as $child)
            $child->isLeaf() ?
                $result->push($child) :
                $result = $result->merge($this->getAllFilesGroupFromNode($child));

        return $result;
    }

    /** Создает zip архив от заданной папки с всеми файлам и пустыми папками */
    public function generateZipArchive(Task $task, TaskFilesScheme $taskFilesScheme): string
    {
        $zip = new ZipArchive;
        $archiveFileMame = $this->sanitizingFileName($this->zipArchiveFolder . DIRECTORY_SEPARATOR . $task->subject.'_'. now()->timestamp.'.zip');

        throw_unless(
            $zip->open(storage_path($archiveFileMame), ZipArchive::CREATE),
            new \Exception('Failed to create archive')
        );

        $task_files_scheme_ids = TaskFilesScheme::descendantsAndSelf($taskFilesScheme)->toFlatTree()->pluck('id')->toArray();

        $files = $task->getAttachmentsFromTaskAndMessages()->groupBy(function($file) {
            return $file->custom_properties['task_files_scheme_id'];
        });

        foreach ($files as $scheme_id => $filesInGroup){
            if ($scheme = TaskFilesScheme::Find($scheme_id)) {

                $folderPath = $scheme->ancestors->pluck('name','id')->toArray();
                $folderPath = array_slice($folderPath, array_search($taskFilesScheme->id, array_keys($folderPath), true), null, true);
                $folderName = implode(DIRECTORY_SEPARATOR, $folderPath) . DIRECTORY_SEPARATOR . $scheme->name;
                $i = 0;

                foreach ($filesInGroup as $file) {
                    if (in_array($file->getCustomProperty('task_files_scheme_id'), $task_files_scheme_ids)) {
                        $fileName = $this->sanitizingFileName($folderName .
                            DIRECTORY_SEPARATOR .
                            $this->getCorrectFileName($file, $scheme, $i, $filesInGroup->count() === 1));
                        try {
                            $zip->addFile($file->getPath(), $fileName);
                            $i++;
                        } catch (\Exception $exception) {
                        };
                    }
                }
            }
        }

        $zip->close();
        return storage_path($archiveFileMame);
    }
}
