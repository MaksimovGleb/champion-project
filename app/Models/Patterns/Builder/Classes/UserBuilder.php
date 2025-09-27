<?php

namespace App\Models\Patterns\Builder\Classes;

use App\Models\Patterns\Builder\Interfaces\UserBuilderInterface;
use App\Models\User;

class UserBuilder implements UserBuilderInterface
{
    private $user;

    public function __construct()
    {
        $this->create();
    }

    public function create(): UserBuilderInterface
    {
        $this->user = new User();
        return $this;
    }

    public function setName(string $val): UserBuilderInterface
    {
        $this->user->name = $val;
        return $this;
    }

    public function setEmail(string $val): UserBuilderInterface
    {
        $this->user->email = $val;
        return $this;
    }

    public function setPassword(string $val): UserBuilderInterface
    {
        $this->user->password = $val;
        return $this;
    }
}
