<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\File;

class ChangeAvatar extends Command
{

    protected $signature = 'avatar:change';

    protected $description = 'update default avatar';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle2()
    {
        $users = User::all();

        foreach ($users as $user) {
            $avatar = $user->getMedia('avatars')->first();
            if ($avatar?->file_name === 'avatardefault.png'){
                $user->clearMediaCollection('avatars');
                $user->addMedia(public_path('/client/img/avatardefault.png'))
                    ->preservingOriginal()
                    ->toMediaCollection('avatars');
                $this->info(sprintf('[+] user_id: %d avatar has been changed', $user->id ));
            }
            else
                $this->comment(sprintf('[+] user_id: %d avatar: %s scipped', $user->id, $avatar?->file_name ));
        }

    }

    private function getUsersFromFile()
    {
        $fileContents = File::get(app_path('Console/Commands/2.txt'));
        $userIds = explode(PHP_EOL, $fileContents); // Разбиваем содержимое файла по строкам

        // Получаем пользователей по ID
        $users = User::whereIn('id', $userIds)->get();

        return $users;
    }

    public function handle()
    {
        $users = $this->getUsersFromFile();

        foreach ($users as $user) {
            $avatar = $user->getMedia('avatars')->first();
            if ($avatar?->file_name === 'avatardefault.png'){
                $user->clearMediaCollection('avatars');
                $user->addMedia(public_path('/client/img/avatardefault.png'))
                    ->preservingOriginal()
                    ->toMediaCollection('avatars');
                $this->info(sprintf('[+] user_id: %d avatar has been changed', $user->id ));
            }
            else
                $this->comment(sprintf('[-] user_id: %d avatar: %s scipped', $user->id, $avatar?->file_name ));
        }

    }

}
