<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PermissionType extends Enum
{
    // все доступы
    public const UserManagerName = 'Управление пользователями';

    public const UserManagerSlug = 'manage-users';

    // доступ к юристам
    public const UristManagerName = 'Управление юристами';

    public const UristManagerSlug = 'manage-urists';

    // доступ к клиентам
    public const ClientManagerName = 'Управление клиентами';

    public const ClientManagerSlug = 'manage-clients';

    // разрешение на создание таски
    public const CreateTaskName = 'Создание заявки';

    public const CreateTaskSlug = 'create-task';

}
