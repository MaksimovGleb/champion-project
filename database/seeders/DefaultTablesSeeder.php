<?php

namespace Database\Seeders;

use Database\Seeders\Champions\ChampionsSeeder;
use Database\Seeders\Defaults\InitPermissionSeeder;
use Database\Seeders\Defaults\InitRoleSeeder;
use Database\Seeders\Judges\JudgesSeeder;
use Database\Seeders\Releases\Release_1_1_0;
use Illuminate\Database\Seeder;
use Laravel\Telescope\Telescope;

class DefaultTablesSeeder extends Seeder
{
    public function run()
    {
        Telescope::startRecording();
        $this->command->alert('Start sead DefaultTablesSeeder...');

        $this->call([
            InitPermissionSeeder::class,
            InitRoleSeeder::class,

            Release_1_1_0::class,
            ChampionsSeeder::class,
            JudgesSeeder::class,
        ]);

        $this->command->info('[+] Дефолтные данные: Роли, типы услуг заполнены!');
    }
}
