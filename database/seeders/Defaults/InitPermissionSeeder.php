<?php

namespace Database\Seeders\Defaults;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class InitPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::factory()->userManage()->create();
        Permission::factory()->uristManage()->create();
        Permission::factory()->clientManage()->create();
        Permission::factory()->createTaskManage()->create();
    }
}
