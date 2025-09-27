<?php

namespace App\Services\SiteSettings;

use App\Models\Permission;

class UserJuniors
{
    private $juniorStandard;

    private $juniorGeneral;

    private $juniorBFL;

    private $juniorTax;

    private function load()
    {
        $this->juniorStandard = Permission::juniorStandard()->users()->get();
        $this->juniorGeneral = Permission::juniorGeneral()->users()->get();
        $this->juniorBFL = Permission::juniorBFL()->users()->get();
        $this->juniorTax = Permission::juniorTax()->users()->get();
    }

    public function __construct()
    {
        $this->load();
    }

    public function reload()
    {
        $this->load();
    }

    public function getJuniorStandard()
    {
        return $this->juniorStandard;
    }

    public function getJuniorGeneral()
    {
        return  $this->juniorGeneral;
    }

    public function getJuniorBFL()
    {
        return $this->juniorBFL;
    }

    public function getJuniorTax()
    {
        return $this->juniorTax;
    }
}
