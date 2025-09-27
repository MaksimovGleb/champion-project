<?php

namespace Database\Seeders;

use Database\Seeders\Users\UsersTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DefaultTablesSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
