<?php

namespace App\Services\SiteSettings;

use App\Models\Permission;

class PermissionSettings
{

    private $permissions;

    public function __construct()
    {
        $permissions = Permission::all();

        $this->permissions = $permissions;
    }

}
