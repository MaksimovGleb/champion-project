<?php

namespace Database\Factories\Payment;

use App\Enums\PlanType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    public function definition()
    {
        [$keys, $values] = \Arr::divide(PlanType::toArray());
        return [
            'name' => 'Подписка ' . \Str::words($this->faker->realText, 2),
            'description' => \Str::words($this->faker->realText, 10),
            'type_id' => 1,
            'plan_type_id' => $this->faker->randomElement($keys),
        ];
    }
}
