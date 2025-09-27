<?php

namespace App\Services\SiteSettings;

use App\Models\Permission;

class UserSeniors
{
    private $seniorStandard;

    private $seniorGeneral;

    private $seniorBFL;

    private $seniorTax;

    private function load()
    {
        $this->seniorStandard = Permission::seniorStandard()->users()->get();
        $this->seniorGeneral = Permission::seniorGeneral()->users()->get();
        $this->seniorBFL = Permission::seniorBFL()->users()->get();
        $this->seniorTax = Permission::seniorTax()->users()->get();
    }

    public function __construct()
    {
        $this->load();
    }

    public function reload()
    {
        $this->load();
    }

    public function getSeniorStandard()
    {
        return $this->seniorStandard;
    }

    public function getSeniorGeneral()
    {
        return  $this->seniorGeneral;
    }

    public function getSeniorBFL()
    {
        return $this->seniorBFL;
    }

    public function getSeniorTax()
    {
        return $this->seniorTax;
    }
}
