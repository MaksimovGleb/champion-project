<?php

namespace Database\Seeders\Defaults;

use App\Enums\PermissionType;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class InitRoleSeeder extends Seeder
{
    public function run()
    {
        // Создаю роли
        $roleGuest = Role::factory()->guest()->create();
        $roleAdmin = Role::factory()->admin()->create();

        // получаю доступы
        $usersPermission = Permission::where('slug', PermissionType::UserManagerSlug)->first();
        $uristsPermission = Permission::where('slug', PermissionType::UristManagerSlug)->first();
        $clientsPermission = Permission::where('slug', PermissionType::ClientManagerSlug)->first();
        $createTaskPermission = Permission::where('slug', PermissionType::CreateTaskSlug)->first();

        $roleAdmin->permissions()->sync([$usersPermission->id, $uristsPermission->id, $clientsPermission->id, $createTaskPermission->id]);
    }
}
