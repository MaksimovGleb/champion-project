<?php

namespace App\Services\SiteSettings;

use App\Enums\UserRoles;
use App\Models\Role;

class RoleSettings
{
    private $guest;

    private $admin;

    public function __construct()
    {
        $roles = Role::all();
        $this->guest = $roles->where('id', UserRoles::USER_GUEST)->first();
        $this->admin = $roles->where('id', UserRoles::USER_ADMIN)->first();
    }

    public function getGuestRole()
    {
        return $this->guest;
    }

    public function getAdminRole()
    {
        return $this->admin;
    }

    public function getRoleById($roleId): ?Role
    {
        switch ($roleId) {
            case UserRoles::USER_GUEST:
                return $this->getGuestRole();
            case UserRoles::USER_ADMIN:
                return $this->getAdminRole();
        }

        return null;
    }
}
