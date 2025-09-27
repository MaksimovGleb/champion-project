<?php

namespace Database\Seeders\Releases;

use Database\Seeders\Defaults\DefaultNotificationSeeder;
use Illuminate\Database\Seeder;

class Release_1_1_0 extends Seeder
{
    public function run()
    {
        $this->call([
            DefaultNotificationSeeder::class,
        ]);
    }
}
