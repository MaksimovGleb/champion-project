<?php

namespace Database\Factories;

use App\Enums\UserRoles;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    private $guestRole = [
        'id' => UserRoles::USER_GUEST,
        'name' => UserRoles::UserGuestRoleName,
        'slug' => UserRoles::UserGuestRoleSlug,
        'priority' => UserRoles::UserGuestRolePriority,
    ];

    private $adminRole = [
        'id' => UserRoles::USER_ADMIN,
        'name' => UserRoles::UserAdminRoleName,
        'slug' => UserRoles::UserAdminRoleSlug,
        'priority' => UserRoles::UserAdminRolePriority,
    ];

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

        ];
    }

    public function guest()
    {
        $props = $this->guestRole;

        return $this->state(function (array $attributes) use ($props) {
            return $props;
        });
    }

    public function admin()
    {
        $props = $this->adminRole;

        return $this->state(function (array $attributes) use ($props) {
            return $props;
        });
    }

    public function random()
    {
        $props = $this->adminRole;

        return $this->state(function (array $attributes) use ($props) {
            return $props;
        });
    }
}
