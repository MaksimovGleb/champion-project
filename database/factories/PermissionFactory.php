<?php

namespace Database\Factories;

use App\Enums\PermissionType;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    private $usersPermission = [
        'name' => PermissionType::UserManagerName,
        'slug' => PermissionType::UserManagerSlug,
    ];

    private $uristsPermission = [
        'name' => PermissionType::UristManagerName,
        'slug' => PermissionType::UristManagerSlug,
    ];

    private $clientsPermission = [
        'name' => PermissionType::ClientManagerName,
        'slug' => PermissionType::ClientManagerSlug,
    ];

    private $createTaskPermission = [
        'name' => PermissionType::CreateTaskName,
        'slug' => PermissionType::CreateTaskSlug,
    ];

    protected $model = Permission::class;

    public function definition()
    {
        return [
            //
        ];
    }

    public function userManage()
    {
        $props = $this->usersPermission;

        return $this->state(function (array $attributes) use ($props) {
            return $props;
        });
    }

    public function uristManage()
    {
        $props = $this->uristsPermission;

        return $this->state(function (array $attributes) use ($props) {
            return $props;
        });
    }

    public function clientManage()
    {
        $props = $this->clientsPermission;

        return $this->state(function (array $attributes) use ($props) {
            return $props;
        });
    }

    public function createTaskManage()
    {
        $props = $this->createTaskPermission;

        return $this->state(function (array $attributes) use ($props) {
            return $props;
        });
    }

    public function random()
    {
        $index = rand(1, 4);
        $props = [];
        switch ($index) {
            case 1:
                $props = $this->usersPermission;
                break;
            case 2:
                $props = $this->uristsPermission;
                break;
            case 3:
                $props = $this->clientsPermission;
                break;
            default:
                $props = $this->createTaskPermission;
        }

        return $this->state(function (array $attributes) use ($props) {
            return $props;
        });
    }
}
