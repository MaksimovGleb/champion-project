<?php

namespace App\Traits\Tests;

use Illuminate\Foundation\Testing\Traits\CanConfigureMigrationCommands;

trait DatabaseSkipMigrations
{
    use CanConfigureMigrationCommands;

    /*
     * Это пустая копия трейта DatabaseMigrations.
     * Использовать, если не нужно обнулять базу и перенакатывать миграции
     * Цель - ускорить тесты, хотя бы на этапе из разработки
     */
    public function runDatabaseMigrations()
    {
    }
}
