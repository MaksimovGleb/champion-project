<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserRoles extends Enum
{
    public const USER_GUEST = 1;

    public const USER_ADMIN = 4;

    public const UserGuestRoleName = 'Гость';

    public const UserGuestRoleSlug = 'guest';

    public const UserGuestRolePriority = 0;

    public const UserUristRolePriority = 4;

    public const UserAdminRoleName = 'Администратор';

    public const UserAdminRoleSlug = 'admin';

    public const UserAdminRolePriority = 6;

}
