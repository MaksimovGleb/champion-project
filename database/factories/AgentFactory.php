<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AgentFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => 'Агент ' . \Str::words($this->faker->realText, 2),
            'description' => \Str::words($this->faker->realText, 10),
            'address' => \Str::words($this->faker->realText, 10),
            'contacts' => \Str::words($this->faker->realText, 10),
            'username' => \Str::words($this->faker->realText, 10),
            'password' => 'password',
        ];
    }
}
