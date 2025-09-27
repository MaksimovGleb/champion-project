<?php

namespace Database\Factories;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        $emailDomen = $this->faker->randomElement(['@mail.ru',  '@yandex.ru', '@gmail.com']);
        $phoneOperator = $this->faker->randomElement(['985','915', '914', '999', '905', '910']);
        return [
            'name' => $this->faker->firstName($gender),
            'surname' => $this->faker->lastName($gender),
            'patronymic' => $this->faker->middleName($gender),
            'phone' => sprintf('7%s%s', $phoneOperator, $this->faker->unique()->numerify('#######')),
            'avatar' => 'https://lorempixel.com/400/400/people/',
            'email' => preg_replace('/@example\..*/', $emailDomen,
                $this->faker->unique()->safeEmail()),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => UserRoles::USER_ADMIN,
            ];
        });
    }

    public function urist()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => UserRoles::USER_URIST,
            ];
        });
    }

    public function client()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => UserRoles::USER_CLIENT,
            ];
        });
    }
}
