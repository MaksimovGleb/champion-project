<?php

namespace Database\Factories\Payment;

use App\Models\Payment\Condition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionFactory extends Factory
{
    public function definition()
    {
        return [
            'days_count' => $this->faker->numberBetween(1, 999),
            'limit' => $this->faker->numberBetween(1, 999),
            'amount' => $this->faker->numberBetween(100, 25000),
            'currency' => Condition::DEFAULT_CURRENCY,
        ];
    }
}
