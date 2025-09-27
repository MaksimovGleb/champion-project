<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Message::class;

    public function definition()
    {
        return [
            'subject' => 'Комментарий_'.$this->faker->paragraphs(10, true),
            'body' => $this->faker->paragraphs(100, true),
            'user_id' => $this->faker->numberBetween(1, 2),
            'created_at' => $this->faker->dateTimeBetween('-1 years'),
        ];
    }
}
