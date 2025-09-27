<?php

namespace App\Enums;

enum UserRole : int
{
    case GUEST = 1;
    case ADMINISTRATOR = 4;


    public function isGuest(): bool
    {
        return $this === self::GUEST;
    }

    public static function getGuestSlug(): string
    {
        return 'guest';
    }

    public static function getGuestName(): string
    {
        return 'Гость';
    }

    public function isAdministrator(): bool
    {
        return $this === self::ADMINISTRATOR;
    }

    public static function getAdministratorSlug(): string
    {
        return 'admin';
    }

    public static function getAdministratortName(): string
    {
        return 'Администратор';
    }

    public static function toArray() : array
    {
        return [[
                'id'        => self::GUEST,
                'name'      => self::getGuestName(),
                'slug'      => self::getGuestSlug(),
            ],[
                'id'        => self::ADMINISTRATOR,
                'name'      => self::getAdministratortName(),
                'slug'      => self::getAdministratorSlug(),
            ],];
    }

}
