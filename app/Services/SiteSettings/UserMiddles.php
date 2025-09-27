<?php

namespace App\Services\SiteSettings;

use App\Models\Permission;

class UserMiddles
{
    private $middleStandard;

    private $middleGeneral;

    private $middleBFL;

    private $middleTax;

    private function load()
    {
        $this->middleStandard = Permission::middleStandard()->users()->get();
        $this->middleGeneral = Permission::middleGeneral()->users()->get();
        $this->middleBFL = Permission::middleBFL()->users()->get();
        $this->middleTax = Permission::middleTax()->users()->get();
    }

    public function __construct()
    {
        $this->load();
    }

    public function reload()
    {
        $this->load();
    }

    public function getMiddleStandard()
    {
        return $this->middleStandard;
    }

    public function getMiddleGeneral()
    {
        return  $this->middleGeneral;
    }

    public function getMiddleBFL()
    {
        return $this->middleBFL;
    }

    public function getMiddleTax()
    {
        return $this->middleTax;
    }
}
