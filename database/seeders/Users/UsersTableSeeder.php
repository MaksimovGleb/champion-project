<?php

namespace Database\Seeders\Users;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        //отключение observer
        $dispatcher = User::getEventDispatcher();
        User::unsetEventDispatcher(); // Отключение observer.

        User::factory()->hasAttached(Role::factory()->admin()->make())->create([
            'name' => 'Посетитель',
            'email' => 'client@mail.ru',
            'password' => bcrypt('password')
        ]);

        User::setEventDispatcher($dispatcher); // Включить observer.
    }
}
