<?php

namespace Database\Factories\Payment;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => 'Услуга ' . $this->faker->word,
            'description' => $this->faker->paragraph
        ];
    }
}
