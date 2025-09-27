<?php

namespace App\Models\Patterns\Builder\Interfaces;

use App\Models\User;

interface UserBuilderInterface
{
    public function create(): UserBuilderInterface;

    public function setName(string $val): UserBuilderInterface;

    public function setEmail(string $val): UserBuilderInterface;

    public function setPassword(string $val): UserBuilderInterface;
}
